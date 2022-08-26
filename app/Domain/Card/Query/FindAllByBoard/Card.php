<?php

namespace App\Domain\Card\Query\FindAllByBoard;

class Card
{
    public function __construct(
        public string $id,
        public string $name,
        public string $description,
        public int $sequence,
        public string $listId,
    ) {}
}
