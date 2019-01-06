<?php

namespace App\Http\Controllers;

use App\Jobs\PostSlackMessage;
use App\Jobs\SendEvemail;
use App\Whitelist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ContactFormController extends Controller
{

    public function index()
    {
        return view('contact-form');
    }

    public function send(Request $request)
    {
        $input = $request->all();

        $this->sendMail($input['text']);
        $this->postSlack($input['text']);

        return view('/contact-form-result');
    }

    /**
     * @param string $text
     */
    private function sendMail($text)
    {
        $recipients = [];
        foreach (Whitelist::where('is_admin', 1)->get() as $admin) {
            $recipients[] = [
                'recipient_id' => $admin->eve_id,
                'recipient_type' => 'character'
            ];
        }

        if (count($recipients) === 0) {
            Log::error('ContactFormController: no recipients found.');
            return;
        }

        $mail = array(
            'body' => $text,
            'recipients' => $recipients,
            'subject' => 'Contact Form',
            'approved_cost' => 0,
        );

        SendEvemail::dispatch($mail);
    }

    /**
     * @param string $text
     */
    private function postSlack($text)
    {
        $webHookUrl = env('SLACK_WEBHOOK_URL');
        $body = ['text' => $text];

        PostSlackMessage::dispatch($webHookUrl, $body);
    }
}
