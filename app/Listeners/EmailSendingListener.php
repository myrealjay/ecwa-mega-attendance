<?php

namespace App\Listeners;

use App\Models\EmailMessage;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class EmailSendingListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $message = $event->message;
        $addresses = $message->getTo();
        $body = $message->getHtmlBody();
        $subject = $message->getSubject();
        $date = $message->getDate();

        $to = '';

        foreach($addresses as $address) {
            $to .= $address->getAddress() .',';
        };
        
        EmailMessage::create([
            'date' => $date,
            'subject' => $subject,
            'content' => $body,
            'to' => $to
        ]);
    }
}
