<?php

namespace App\Jobs;

use App\Models\Moon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CalculateRent implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 10;

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $calc = new \App\Classes\CalculateRent();

        // Grab all of the moon records and loop through them.
        $moons = Moon::all();
        foreach ($moons as $moon) {
            // Save the current month's rental fee.
            $moon->previous_monthly_rental_fee = $moon->monthly_rental_fee;
            $monthly_rental_fee = $calc->updateMoon($moon);

            Log::info(
                'CalculateRent: updated stored monthly rental fee for moon ' . $moon->id .
                ' to ' . $monthly_rental_fee
            );

            // Update the monthly rent figure if this moon is currently rented.
            DB::table('renters')->where('moon_id', $moon->id)->update([
                'monthly_rental_fee' => $monthly_rental_fee,
            ]);
        }
    }
}
