<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class WalletDebitNotification extends Notification
{
    use Queueable;
    public float $amount;
    public string $currency;
    public string $ref;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(float $amount, string $currency, $ref)
    {
        $this->amount = $amount;
        $this->currency = $currency;
        $this->ref = $ref;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->greeting("Hello {$notifiable->first_name}")
                    ->line("Your $this->currency wallet has been debited with $this->amount.")
                    ->line("Ref: $this->ref")
                    ->line('Thank you for using BlackBank!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
