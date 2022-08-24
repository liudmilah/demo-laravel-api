<?php
declare(strict_types=1);

namespace App\Domain\User\Listeners;

use App\Domain\User\Events\UserRegistered;
use Illuminate\Contracts\Auth\MustVerifyEmail;

final class SendEmailVerificationNotification
{
    public function handle(UserRegistered $event)
    {
        if ($event->user instanceof MustVerifyEmail && ! $event->user->hasVerifiedEmail()) {
            $event->user->sendEmailVerificationNotification();
        }
    }
}
