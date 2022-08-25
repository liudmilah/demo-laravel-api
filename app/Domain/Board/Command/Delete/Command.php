<?php
declare(strict_types=1);

namespace App\Domain\Board\Command\Delete;

use App\Domain\Id;

final class Command
{
    public function __construct(
        public Id $boardId,
        public Id $userId,
    ) {}
}
