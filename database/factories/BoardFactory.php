<?php

namespace Database\Factories;

use App\Domain\Id;
use App\Domain\Board\Board;
use Illuminate\Database\Eloquent\Factories\Factory;

class BoardFactory extends Factory
{
    protected $model = Board::class;

    public function definition(): array
    {
        return [
            'id' => Id::generate(),
            'name' => fake()->name(),
        ];
    }

    public function id(string $id): BoardFactory
    {
        return $this->state(fn (array $attributes) => [ 'id' => new Id($id) ]);
    }

    public function name(string $name): BoardFactory
    {
        return $this->state(fn (array $attributes) => [ 'name' => $name ]);
    }
}
