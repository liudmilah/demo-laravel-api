<?php
declare(strict_types=1);

namespace App\Domain\BoardList\Command\Create;

use App\Domain\Id;
use App\Domain\User\User;

final class Command
{
    public function __construct(
        public string $name,
        public int $sequence,
        public Id $boardId,
        public User $user,
    ) {}
}
