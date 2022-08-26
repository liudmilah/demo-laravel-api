<?php
declare(strict_types=1);

namespace App\Domain\BoardList\Command\Delete;

use App\Domain\Id;

final class Command
{
    public function __construct(
        public Id $listId,
        public Id $userId,
    ) {}
}
