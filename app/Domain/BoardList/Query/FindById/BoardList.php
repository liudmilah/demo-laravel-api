<?php

namespace App\Domain\BoardList\Query\FindById;

class BoardList
{
    public function __construct(
        public string $id,
        public string $name,
        public int $sequence,
    ) {}
}
