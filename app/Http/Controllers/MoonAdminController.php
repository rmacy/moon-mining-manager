<?php

namespace App\Http\Controllers;

use App\Classes\EsiConnection;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Moon;
use App\Models\Region;
use App\Models\SolarSystem;
use App\Models\Type;
use App\Models\TaxRate;
use App\Jobs\UpdateReprocessedMaterials;
use App\Jobs\UpdateMaterialValues;
use Illuminate\Support\Facades\Log;

class MoonAdminController extends Controller
{

    protected $total_ore_volume = 14000000; // 14m m3 represents a thirty day mining cycle, approximately

    private $romans = [
        'M' => 1000,
        'CM' => 900,
        'D' => 500,
        'CD' => 400,
        'C' => 100,
        'XC' => 90,
        'L' => 50,
        'XL' => 40,
        'X' => 10,
        'IX' => 9,
        'V' => 5,
        'IV' => 4,
        'I' => 1,
    ];

    public function index()
    {
        $moons = Moon::orderBy('region_id')->orderBy('solar_system_id')->orderBy('planet')->orderBy('moon')->get();
        return view('moons.list', [
            'moons' => $moons,
        ]);
    }

    public function admin()
    {
        return view('moons.admin');
    }

    public function import(Request $request)
    {

        // Convert the dump of spreadsheet data into a structured array.
        $data = [];
        $lines = explode("\n", $request->input('data'));
        foreach ($lines as $line) {
            $data[] = explode("\t", $line);
        }

        // Loop through each row and process it into the database.
        foreach ($data as $row) {
            $moon = new Moon;
            $moon->region_id = Region::where('regionName', $row[0])->first()->regionID;
            $moon->solar_system_id = SolarSystem::where('solarSystemName', $row[1])->first()->solarSystemID;
            $moon->planet = $row[2];
            $moon->moon = $row[3];
            /*
            if ($row[4])
            {
                $moon->renter_id = Miner::where('name', $row[4])->first()->eve_id;
            }
            */
            $moon->mineral_1_type_id = Type::where('typeName', $row[5])->first()->typeID;
            $moon->mineral_1_percent = str_replace(',', '.', $row[6]);
            $moon->mineral_2_type_id = Type::where('typeName', $row[7])->first()->typeID;
            $moon->mineral_2_percent = str_replace(',', '.', $row[8]);
            if ($row[9]) {
                $moon->mineral_3_type_id = Type::where('typeName', $row[9])->first()->typeID;
                $moon->mineral_3_percent = str_replace(',', '.', $row[10]);
            }
            if ($row[11]) {
                $moon->mineral_4_type_id = Type::where('typeName', $row[11])->first()->typeID;
                $moon->mineral_4_percent = str_replace(',', '.', $row[12]);
            }
            $moon->monthly_rental_fee = 0;
            $moon->previous_monthly_rental_fee = 0;
            $moon->save();
        }

        // Redirect back to admin.
        return redirect('/moon-admin')->with('message', 'Import done.');

    }

    /** @noinspection PhpUnused */
    public function importSurveyData(Request $request)
    {
        $added = 0;
        $updated = 0;

        $moon = null;
        $newMoon = false;
        $num = 0;
        $planet = null;
        $moonNumber = null;

        foreach (explode("\n", $request->input('data')) as $row) {
            $cols = explode("\t", $row);

            // new moon?
            $matches = [];
            if (preg_match('/([A-Z0-9-]{6}) ([XVI]{1,4}) - Moon ([0-9]{1,2})/', trim($cols[0]), $matches)) {
                // save previous moon
                if ($moon instanceof Moon) {
                    $moon->save();
                }

                $newMoon = true;
                $num = 0;
                $planet = $this->romanNumberToInteger($matches[2]);
                $moonNumber = $matches[3];

                continue;
            }

            if ($newMoon) {
                $newMoon = false;
                $solarSystem = trim($cols[4]);
                $moon = Moon::where([
                    ['solar_system_id', $solarSystem],
                    ['planet', $planet],
                    ['moon', $moonNumber],
                ])->first();
                if (! $moon) {
                    $moon = new Moon();
                    $added ++;
                } else {
                    $updated ++;
                }
                $moon->solar_system_id = $solarSystem;
                $moon->planet = $planet;
                $moon->moon = $moonNumber;
                $moon->monthly_rental_fee = 0;
                $moon->previous_monthly_rental_fee = 0;
            } elseif ($moon === null) {
                // skip the headline
                continue;
            }

            // moon ore data
            $num ++;
            $moon->region_id = SolarSystem::where('solarSystemID', $moon->solar_system_id)->first()->regionID;
            $moon->{'mineral_' . $num . '_type_id'} = trim($cols[3]);
            $moon->{'mineral_' . $num . '_percent'} = trim($cols[2]) * 100;
        }

        // save last moon
        if ($moon instanceof Moon) {
            $moon->save();
        }

        // Redirect back to admin.
        return redirect('/moon-admin')->with(
            'message',
            "Import done: $added moons added, $updated moons updated."
        );
    }

    /**
     * @throws \Exception
     */
    public function export()
    {
        $conn = (new EsiConnection())->getConnection();

        $rows = [];
        $rows[] = [
            'Region',
            'System',
            'ID',
            'Location',
            'P',
            'M',
            'Renter (char ID)',
            'Renter (char name)',
            'status',
            '',
            'Mineral 1',
            '% 1',
            'Mineral 2',
            '% 2',
            'Mineral 3',
            '% 3',
            'Mineral 4',
            '% 4',
        ];

        foreach (Moon::all()->sortBy('id') as $moon) {
            /* @var $moon Moon */

            // get renter name from DB if available, otherwise from ESI
            $renterCharId = $moon->getActiveRenterAttribute() ? $moon->getActiveRenterAttribute()->character_id : null;
            $renterName = '';
            if ($renterCharId) {
                $user = User::where('eve_id', '=', $renterCharId)->first();
                if ($user) {
                    $renterName = $user->name;
                } else {
                    $renterName = $conn->invoke('get', '/characters/{character_id}/', [
                        'character_id' => $renterCharId,
                    ])->name;
                }
            }

            $cols = [
                $moon->region ? $moon->region->regionName : '',
                $moon->system ? $moon->system->solarSystemName : '',
                $moon->id,
                $this->integerToRomanNumber($moon->planet) . ' - M ' . $moon->moon,
                $moon->planet,
                $moon->moon,
                $renterCharId,
                $renterName, //
                '', // status
                '', //
                $moon->mineral_1->typeName,
                $moon->mineral_1_percent . '%',
                $moon->mineral_2->typeName,
                $moon->mineral_2_percent . '%',
                $moon->mineral_3 ? $moon->mineral_3->typeName : '',
                $moon->mineral_3_percent ? $moon->mineral_3_percent . '%' : '',
                $moon->mineral_4 ? $moon->mineral_4->typeName : '',
                $moon->mineral_4_percent ? $moon->mineral_4_percent . '%' : '',
            ];
            $rows[] = $cols;
        }

        return response($this->arrayToCsv($rows), 200, [
            'Content-Type' => 'text/cvs',
            'Content-disposition' => 'attachment;filename=moon-export.csv'
        ]);
    }

    /**
     * Calculate the monthly rental fee for every moon, based on its mineral composition.
     */
    public function calculate()
    {

        // Grab all of the moon records and loop through them.
        $moons = Moon::all();
        foreach ($moons as $moon) {
            // Set the monthly rental value to zero.
            $monthly_rental_fee = 0;

            $monthly_rental_fee += $this->calculateOreTaxValue(
                $moon->mineral_1_type_id, $moon->mineral_1_percent, $moon->solar_system_id
            );
            $monthly_rental_fee += $this->calculateOreTaxValue(
                $moon->mineral_2_type_id, $moon->mineral_2_percent, $moon->solar_system_id
            );
            if ($moon->mineral_3_type_id) {
                $monthly_rental_fee += $this->calculateOreTaxValue(
                    $moon->mineral_3_type_id, $moon->mineral_3_percent, $moon->solar_system_id
                );
            }
            if ($moon->mineral_4_type_id) {
                $monthly_rental_fee += $this->calculateOreTaxValue(
                    $moon->mineral_4_type_id, $moon->mineral_4_percent, $moon->solar_system_id
                );
            }

            // Save the updated rental fee.
            $moon->monthly_rental_fee = $monthly_rental_fee;
            $moon->save();
        }

        // Redirect back to admin.
        return redirect('/moon-admin')->with('message', 'Calculation done.');

    }

    private function calculateOreTaxValue($type_id, $percent, $solar_system_id)
    {
        // Retrieve the value of the mineral from the taxes table.
        $tax_rate = TaxRate::where('type_id', $type_id)->first();

        // If we don't have a stored tax rate for this ore type, queue a job to calculate it.
        if (isset($tax_rate)) {
            // Grab the stored value of this ore.
            $ore_value = $tax_rate->value;

            // Calculate what volume of the total ore will be this type.
            $ore_volume = $this->total_ore_volume * $percent / 100;

            // Based on the volume of the ore type, how many units does that volume represent.
            $type = Type::find($type_id);
            $units = $ore_volume / $type->volume;

            // Calculate the tax rate to apply (premium applied in the Impass pocket).
            $tax_rate = (SolarSystem::find($solar_system_id)->constellationID == 20000383) ? 10 : 7;

            // For non-moon ores, apply a 50% discount.
            $discount = (in_array($type->groupID, [1884, 1920, 1921, 1922, 1923])) ? 1 : 0.5;

            // Calculate the tax value to be charged for the volume of this ore that can be mined.
            return $ore_value * $units * $tax_rate / 100 * $discount;
        } else {
            // Add a new record for this unknown ore type.
            $tax_rate = new TaxRate;
            $tax_rate->type_id = $type_id;
            $tax_rate->check_materials = 1;
            $tax_rate->value = 0;
            $tax_rate->tax_rate = 7;
            $tax_rate->updated_by = 0;
            $tax_rate->save();
            Log::info('MoonAdminController: unknown ore ' . $type_id . ' found, new tax rate record created');
            // Queue the jobs to update the ore values rather than waiting for the next scheduled job.
            UpdateReprocessedMaterials::dispatch();
            UpdateMaterialValues::dispatch();

            return 0;
        }
    }

    private function romanNumberToInteger($roman)
    {
        $result = 0;
        foreach ($this->romans as $key => $value) {
            while (strpos($roman, $key) === 0) {
                $result += $value;
                $roman = substr($roman, strlen($key));
            }
        }
        return $result;
    }

    private function integerToRomanNumber($number)
    {
        $returnValue = '';
        while ($number > 0) {
            foreach ($this->romans as $roman => $int) {
                if ($number >= $int) {
                    $number -= $int;
                    $returnValue .= $roman;
                    break;
                }
            }
        }
        return $returnValue;
    }

    private function arrayToCsv(array $rows)
    {
        $result = '';

        $fp = fopen('php://temp', 'w');

        foreach ($rows as $fields) {
            fputcsv($fp, $fields, ';', '"');
        }

        rewind($fp);
        while (($buffer = fgets($fp, 4096)) !== false) {
            $result .= $buffer;
        }

        fclose($fp);

        return $result;
    }
}
