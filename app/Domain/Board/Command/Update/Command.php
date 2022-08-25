<?php
declare(strict_types=1);

namespace App\Domain\Board\Command\Update;

use App\Domain\Id;

final class Command
{
    public function __construct(
        public Id $boardId,
        public Id $userId,
        public string $name,
    ) {}
}
