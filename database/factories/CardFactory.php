<?php

namespace Database\Factories;

use App\Domain\Id;
use App\Domain\Board\BoardList;
use Illuminate\Database\Eloquent\Factories\Factory;

class CardFactory extends Factory
{
    protected $model = BoardList::class;

    public function definition(): array
    {
        return [
            'id' => Id::generate(),
            'name' => fake()->text(100),
            'description' => fake()->text(255),
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
