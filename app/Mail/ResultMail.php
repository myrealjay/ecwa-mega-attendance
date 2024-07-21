<?php

namespace App\Mail;

use App\Models\Quiz;
use App\Models\UserQuiz;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ResultMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public UserQuiz $userQuiz;
    public Quiz $quiz;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(UserQuiz $userQuiz, Quiz $quiz)
    {
        $this->userQuiz = $userQuiz;
        $this->quiz = $quiz;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: 'Quiz Result Mail',
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new Content(
            view: 'Result',
            with: [
                'name' => $this->userQuiz->user->first_name,
                'userQuiz' => $this->userQuiz,
                'breakdown' => $this->userQuiz->breakdown,
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
