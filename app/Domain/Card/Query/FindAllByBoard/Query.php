<?php

namespace App\Domain\Card\Query\FindAllByBoard;

use App\Domain\Id;

class Query
{
    public function __construct(
        public Id $boardId,
        public Id $userId,
    ) {}
}
