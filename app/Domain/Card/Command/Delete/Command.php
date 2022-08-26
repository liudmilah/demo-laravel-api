<?php
declare(strict_types=1);

namespace App\Domain\Card\Command\Delete;

use App\Domain\Id;

final class Command
{
    public function __construct(
        public Id $cardId,
        public Id $userId,
    ) {}
}
