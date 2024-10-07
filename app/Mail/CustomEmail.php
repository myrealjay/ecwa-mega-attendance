<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CustomEmail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public string $template;
    public ?string $mySubject;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(string $template, ?string $subject = null)
    {
        $this->template = $template;
        $this->mySubject = $subject;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: $this->mySubject,
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        $template = $this->template;

        return new Content(
            view:'FollowUp',
            with:[
                'parsedtemplate' => $template
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
