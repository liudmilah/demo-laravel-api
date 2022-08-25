<?php

namespace App\Domain\Board\Query\FindById;

class Board
{
    public function __construct(
        public string $id,
        public string $name,
    ) {}
}
