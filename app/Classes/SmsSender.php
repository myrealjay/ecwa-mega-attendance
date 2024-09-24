<?php
namespace App\Classes;

use App\Models\SmsMessage;
use App\Models\SmsTemplate;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SmsSender
{
    public function send($phoneNumbers = [], SmsTemplate $template , User $user) : void
    {
        $body = (new TemplateParser())->parse($template->template, $user);
        $phoneNumbers = $this->formatNumbers($phoneNumbers);
        $phones = rtrim(implode(",", $phoneNumbers), ',');

        $sms = SmsMessage::create([
            'phone_number' => $phones,
            'status' => 'Pending',
            'content' => $body
        ]);
        
        $data = [
            'api_token' => config('services.bulksmsnigeria.api_token'),
            'from' => 'ECWAMEGA',
            'to' => $phones,
            "gateway" => "direct-refund",
            'body' => $body,
            "customer_reference" => $sms->id,
            'callback_url' => 'https://webhook.site/4abdd5cc-5128-45a8-9f77-bb0ce80213f9' //config('app.url')."/sms"
        ];

        Log::info('Sending SMS to '.$phones);

        $response = Http::post(config('services.bulksmsnigeria.url'), $data)->json();

        Log::info($response);
    }

    protected function formatNumbers(array $numbers) : array
    {
        $numbers = collect($numbers)->map(function(?string $number) {
            $number = ltrim($number, '0');
            $number = ltrim($number, '+2340');
            $number = ltrim($number, '+234');
            $number = ltrim($number, '2340');
            $number = ltrim($number, '234');
            $number = $number ? trim('234'.$number) : '';
            return $number;
        })->reject(function ($number) {
            return empty($number);
        })->toArray();

        return $numbers;
    }
}
