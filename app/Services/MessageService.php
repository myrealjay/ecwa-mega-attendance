<?php

namespace App\Services;

use App\Classes\SmsSender;
use App\Http\Requests\CustomMessageRequest;
use App\Mail\CustomEmail;
use App\Traits\HasResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class MessageService
{
    use HasResponse;

    /**
     * Send message.
     *
     * @param CustomMessageRequest $request
     * 
     * @return JsonResponse
     */
    public function send(CustomMessageRequest $request) : JsonResponse
    {
        $emails = explode(',', $request->emails);
        $phoneNumbers = explode(',', $request->phoneNumbers);

        $textMesage = $request->textMessage;
        $emailMessage = $request->mailMessage;

        $smsSender = new SmsSender();

        if ($emailMessage) {
            foreach($emails as $email) {
                try {
                    Log::info('sending to '.$email);
                    Mail::to($email)->send(new CustomEmail($emailMessage, $request->subject));
                } catch(\Exception $e) {
                    Log::error($e);
                }
            }
        }

        if ($textMesage) {
            foreach($phoneNumbers as $phone) {
                try {
                    $smsSender->sendWithoutTemplate([$phone], $textMesage);
                } catch (\Exception $e) {
                    Log::error($e);
                }
            }
        }

        return $this->successResponse('Messages sent successfully', []);
        
    }
}
