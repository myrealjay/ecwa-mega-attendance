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
    protected ?string $password;

    public function handle(UserCreated $event)
    {
        $this->user = $event->user;
        $this->password = $event->password;
        $this->sendEmail();
    }

    protected function sendEmail()
    {
        if ($this->user instanceof MustVerifyEmail && ! $this->user->hasVerifiedEmail()) {
            try {
                $this->user->sendEmailVerification($this->password);
            }catch(\Exception $exception) {
                logger($exception);
            }
            
        }
    }
}
