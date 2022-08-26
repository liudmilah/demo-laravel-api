<?php

namespace Database\Factories;

use App\Domain\Card\Card;
use App\Domain\Id;
use Illuminate\Database\Eloquent\Factories\Factory;

class CardFactory extends Factory
{
    protected $model = Card::class;

    public function definition(): array
    {
        return [
            'id' => Id::generate(),
            'name' => fake()->text(100),
            'description' => fake()->text(255),
            'sequence' => 0,
        ];
    }

    public function id(string $id): CardFactory
    {
        return $this->state(fn (array $attributes) => [ 'id' => new Id($id) ]);
    }

    public function name(string $name): CardFactory
    {
        return $this->state(fn (array $attributes) => [ 'name' => $name ]);
    }

    public function sequenceNumber(int $sequence): CardFactory
    {
        return $this->state(fn (array $attributes) => [ 'sequence' => $sequence ]);
    }

    public function description(string $description): CardFactory
    {
        return $this->state(fn (array $attributes) => [ 'description' => $description ]);
    }
}
