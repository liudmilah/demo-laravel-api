<?php
declare(strict_types=1);

namespace App\Domain\Board\Command\Create;

use App\Domain\User\User;

final class Command
{
    public function __construct(
        public string $name,
        public User $user,
    ) {}
}
