<?php

namespace App\Mail;
use Illuminate\Auth\Notifications\VerifyEmail as DefaultVerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Lang;

class VerifyEmail extends DefaultVerifyEmail
{
    protected string $password;
    protected $notifiable;

    /**
     * Sending User created email.
     *
     * @param mixed $notifiable
     * @param string $password
     */
    public function __construct(mixed $notifiable, string $password)
    {
        $this->password = $password;
    }

    /**
     * Build the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $this->notifiable = $notifiable;
        $verificationUrl = $this->verificationUrl($notifiable);

        if (static::$toMailCallback) {
            return call_user_func(static::$toMailCallback, $notifiable, $verificationUrl);
        }

        return $this->buildMailMessage($verificationUrl);
    }

    /**
     * Get the verify email notification mail message for the given URL.
     *
     * @param  string  $url
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    protected function buildMailMessage($url)
    {
        return (new MailMessage)
            ->greeting('Hello '. $this->notifiable->first_name .'!')
            ->subject(Lang::get('Verify Email Address'))
            ->line("You default password is: $this->password")
            ->line('Please change the password as soon you you login')
            ->line(Lang::get('Kindly click the button below to verify your email address.'))
            ->action(Lang::get('Verify Email Address'), $url);
    }
}
