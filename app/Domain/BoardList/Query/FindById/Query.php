<?php

namespace App\Domain\BoardList\Query\FindById;

use App\Domain\Id;

class Query
{
    public function __construct(
        public Id $listId,
        public Id $userId,
    ) {}
}
