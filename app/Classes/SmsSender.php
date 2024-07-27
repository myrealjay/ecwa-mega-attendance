<?php
namespace App\Classes;

use App\Models\SmsTemplate;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SmsSender
{
    public function send($phoneNumbers = [], SmsTemplate $template , User $user) : void
    {
        $body = (new TemplateParser())->parse($template->template, $user);
        $phones = implode(",", $phoneNumbers);
        $data = [
            'api_token' => config('services.bulksmsnigeria.api_token'),
            'from' => 'BulkSMS.ng',
            'to' => $phones,
            'dnd' => 2,
            'body' => $body,
            'callback_url' => config('app.url')."/sms"
        ];

        Log::info('Sending SMS to '.$phones);

        $response = Http::post(config('services.bulksmsnigeria.url'), $data)->json();
    }
}
