<?php

namespace Database\Factories;

use App\Domain\BoardList\BoardList;
use App\Domain\Id;
use Illuminate\Database\Eloquent\Factories\Factory;

class BoardListFactory extends Factory
{
    protected $model = BoardList::class;

    public function definition(): array
    {
        return [
            'id' => Id::generate(),
            'name' => fake()->text(100),
            'sequence' => 0,
        ];
    }

    public function id(string $id): BoardListFactory
    {
        return $this->state(fn (array $attributes) => [ 'id' => new Id($id) ]);
    }

    public function name(string $name): BoardListFactory
    {
        return $this->state(fn (array $attributes) => [ 'name' => $name ]);
    }

    public function sequenceNumber(int $sequence): BoardListFactory
    {
        return $this->state(fn (array $attributes) => [ 'sequence' => $sequence ]);
    }
}
