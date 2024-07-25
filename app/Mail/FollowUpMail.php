<?php

namespace App\Mail;

use App\Classes\TemplateParser;
use App\Models\EmailTemplate;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class FollowUpMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public User $user;
    public EmailTemplate $template;
    public $mySubject;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, EmailTemplate $template, $subject = 'Ecwa Mega Checking up on You')
    {
        $this->user = $user;
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
        $template = (new TemplateParser)->parse($this->template->template, $this->user);

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
