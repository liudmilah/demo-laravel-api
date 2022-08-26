<?php

namespace App\Domain\BoardList\Query\FindAllByBoard;

use App\Domain\Id;

class Query
{
    public function __construct(
        public Id $boardId,
        public Id $userId,
    ) {}
}
