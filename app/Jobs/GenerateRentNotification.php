<?php

namespace App\Jobs;

use App\Classes\EsiConnection;
use App\Models\Renter;
use App\Models\Template;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class GenerateRentNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 10;
    private $id;
    private $mail_delay;

    /**
     * Create a new job instance.
     *
     * @param int $id
     * @return void
     */
    public function __construct($id, $mail_delay = 20)
    {
        $this->id = $id;
        $this->mail_delay = $mail_delay;
    }

    /**
     * Execute the job.
     *
     * @return void
     * @throws \Exception
     */
    public function handle()
    {
        // Retrieve the renter record.
        $renter = Renter::find($this->id);

        // Request the character name for this rental agreement.
        $esi = new EsiConnection;
        $character = $esi->getConnection()->invoke('get', '/characters/{character_id}/', [
            'character_id' => $renter->character_id,
        ]);

        // Grab a reference to the refinery/moon that is being rented.
        $nameRented = $renter->getRentedName();
        if ($nameRented === null) {
            Log::info("GenerateRentNotification: Renter $renter->id without moon, aborting.");
            return;
        }

        // Round the rental amount since we don't need to worry about cents.
        $monthly_rental_fee = round($renter->monthly_rental_fee);

        // Pick up the renter notice template to apply text substitutions.
        $template = Template::where('name', 'renter_notification')->first(); /* @var Template $template */

        // Grab the template subject and body.
        $subject = $template->subject;
        $body = $template->body;

        // Replace placeholder elements in email template.
        $subject = str_replace('{date}', date('Y-m-d'), $subject);
        $subject = str_replace('{name}', $character->name, $subject);
        $subject = str_replace('{monthly_rental_fee}', number_format($monthly_rental_fee), $subject);
        $body = str_replace('{date}', date('Y-m-d'), $body);
        $body = str_replace('{name}', $character->name, $body);
        $body = str_replace('{refinery}', $nameRented, $body);
        $body = str_replace('{monthly_rental_fee}', number_format($monthly_rental_fee), $body);
        $mail = array(
            'body' => $body,
            'recipients' => array(
                array(
                    'recipient_id' => $renter->character_id,
                    'recipient_type' => 'character'
                )
            ),
            'subject' => $subject,
            'approved_cost' => 0,
        );

        // Queue sending the eve mail, spaced at 1 minute intervals to avoid triggering the mailspam limiter (4/min).
        SendEvemail::dispatch($mail)->delay(Carbon::now()->addMinutes($this->mail_delay));
        Log::info('GenerateRentNotification: dispatched job to send mail in ' . $this->mail_delay . ' minutes', [
            'mail' => $mail,
        ]);
    }
}
