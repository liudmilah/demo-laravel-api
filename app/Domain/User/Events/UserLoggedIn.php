<?php
declare(strict_types=1);

namespace App\Domain\User\Events;

use App\Domain\User\User;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

final class UserLoggedIn
{
    use Dispatchable, SerializesModels;

    public function __construct(public User $user) {}
}
