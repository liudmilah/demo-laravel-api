<?php

namespace App\Domain\Board\Query\FindById;

use App\Domain\Id;

class Query
{
    public function __construct(
        public Id $boardId,
        public Id $userId,
    ) {}
}
