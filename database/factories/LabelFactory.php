<?php

namespace Database\Factories;

use App\Domain\Card\Label;
use App\Domain\Id;
use Illuminate\Database\Eloquent\Factories\Factory;

class LabelFactory extends Factory
{
    protected $model = Label::class;

    public function definition(): array
    {
        return [
            'id' => Id::generate(),
            'color' => fake()->name(),
        ];
    }

    public function color(string $color): LabelFactory
    {
        return $this->state(fn (array $attributes) => [ 'color' => $color ]);
    }
}
