<?php
declare(strict_types=1);

namespace App\Domain\Card\Command\Create;

use App\Domain\Id;

final class Command
{
    public function __construct(
        public string $name,
        public string $description,
        public int $sequence,
        public Id $listId,
        public Id $boardId,
        public Id $userId,
    ) {}
}
