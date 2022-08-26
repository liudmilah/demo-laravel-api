<?php

namespace App\Domain\BoardList\Query\FindAllByBoard;

class BoardList
{
    public function __construct(
        public string $id,
        public string $name,
        public int $sequence,
    ) {}
}
