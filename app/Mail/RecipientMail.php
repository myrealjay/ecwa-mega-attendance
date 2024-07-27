<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RecipientMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $recipient, $data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(string $data, User $recipient)
    {
        $this->data = $data;
        $this->recipient = $recipient;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: 'People absent from church',
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        $data = "<h2>Hi {$this->recipient->name}, </h2>
        <p>The following members did not attend service today, 
        Kindly reachout to them to know what might be wrong:</p>
        <p>$this->data</p>";

        return new Content(
            view:'FollowUp',
            with:[
                'parsedtemplate' => $data
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }
}
