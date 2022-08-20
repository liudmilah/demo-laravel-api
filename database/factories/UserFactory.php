<?php

namespace Database\Factories;

use App\Domain\Id;
use App\Domain\User\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition(): array
    {
        return [
            'id' => Id::generate(),
            'name' => fake()->name(),
            'email' => fake()->safeEmail(),
            'passwordHash' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        ];
    }
}
