<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Classes\EsiConnection;
use App\Refinery;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class PollStructures implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 3;

    /**
     * @var int
     */
    private $page;

    /**
     * Create a new job instance.
     *
     * @param int $page
     * @return void
     */
    public function __construct($page = 1)
    {
        $this->page = $page;
    }

    /**
     * Execute the job.
     *
     * @return void
     * @throws \Exception
     */
    public function handle()
    {
        $esi = new EsiConnection;

        Log::info('PollStructures: requesting corporation structures, page ' . $this->page);

        // Request all corporation structures of the prime user's corporation.
        $structures = $esi->getConnection($esi->getPrimeUserId())->setQueryString([
            'page' => $this->page,
        ])->invoke('get', '/corporations/{corporation_id}/structures/', [
            'corporation_id' => $esi->getCorporationId($esi->getPrimeUserId()),
        ]);

        // If this is the first page request, we need to check for multiple pages and generate subsequent jobs.
        if ($this->page == 1 && $structures->pages > 1)
        {
            Log::info(
                'PollStructures: found more than 1 page of corporation structures, queuing additional jobs for ' .
                $structures->pages . ' total pages'
            );
            $delay_counter = 1;
            for ($i = 2; $i <= $structures->pages; $i++)
            {
                PollStructures::dispatch($i)->delay(Carbon::now()->addMinutes($delay_counter));
                $delay_counter++;
            }
        }

        // Loop through all the structures, looking for Athanors or Tataras.
        $refineries = array(
            35835, // Athanor
            35836, // Tatara
        );
        $delay_counter = 1;
        foreach ($structures as $structure)
        {
            if (in_array($structure->type_id, $refineries))
            {
                // Found a refinery. If it doesn't already exist, create a record for it.
                $refinery = Refinery::where('observer_id', $structure->structure_id)->first();
                if (!isset($refinery))
                {
                    $refinery = new Refinery;
                    $refinery->observer_id = $structure->structure_id;
                    $refinery->observer_type = 'structure';
                    $refinery->save();
                    Log::info('PollStructures: created new refinery record for ' . $structure->structure_id);
                }
                // Create a new job to fetch or update the parts we don't get from this response.
                PollStructureData::dispatch($structure->structure_id)->delay(Carbon::now()->addMinutes($delay_counter));
                $delay_counter++;
            }
        }

    }

}
