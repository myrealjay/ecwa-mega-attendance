<?php

namespace App\Listeners;

use App\Events\UserCreated;
use App\Models\User;
use App\Models\UserWallet;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendUserCreatedEmail
{
    protected User $user;

    public function handle(UserCreated $event)
    {
        $this->user = $event->user;
        $this->sendEmail();
    }

    protected function sendEmail()
    {
        if ($this->user instanceof MustVerifyEmail && ! $this->user->hasVerifiedEmail()) {
            try {
                $this->user->sendEmailVerificationNotification();
            }catch(\Exception $exception) {
                logger($exception);
            }
            
        }
    }
}
