<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MiningActivity;
use App\Payment;
use Illuminate\Support\Facades\DB;

class ReportsController extends Controller
{
    /**
     * Default report view. Show a table of dates with amount mined per day.
     */
    public function main()
    {

        // Grab all mining activity and payments since all time.
        $mining_activity = MiningActivity::all();
        $payment_activity = Payment::all();

        // Find the first and last dates of recorded mining activity.
        $first_date = date('Y-m-d', strtotime(MiningActivity::orderBy('created_at', 'asc')->first()->created_at));
        $last_date = date('Y-m-d', strtotime(MiningActivity::orderBy('created_at', 'desc')->first()->created_at));

        // Make an array of the entire date range.
        $date = $first_date;
        $dates = [date('m-d', strtotime($date))];
        while ($date < $last_date)
        {
            $date = date('Y-m-d', strtotime($date . ' + 1 day'));
            $dates[] = date('m-d', strtotime($date));
        }

        // Loop through all mining activity, and add values to each date.
        $mining = [];
        foreach ($mining_activity as $row)
        {
            $date = date('m-d', strtotime($row->created_at));
            if (isset($mining[$date]))
            {
                $mining[$date] += $row->quantity;
            }
            else
            {
                $mining[$date] = $row->quantity;
            }
        }

        // Loop through all payments, add values to each date in range.
        $payments = [];
        foreach ($payment_activity as $row)
        {
            $date = date('m-d', strtotime($row->created_at));
            if (isset($payments[$date]))
            {
                $payments[$date] += $row->amount_received;
            }
            else
            {
                $payments[$date] = $row->amount_received;
            }
        }

        return view('reports.main', [
            'dates' => $dates,
            'mining' => $mining,
            'payments' => $payments,
        ]);

    }

}
