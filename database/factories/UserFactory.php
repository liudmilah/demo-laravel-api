<?php

namespace Database\Factories;

use App\Domain\Id;
use App\Domain\User\Status;
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
            'status' => Status::ACTIVE->value,
            'passwordHash' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        ];
    }

    public function active(): UserFactory
    {
        return $this->state(fn (array $attributes) => [ 'status' => Status::ACTIVE ]);
    }

    public function wait(): UserFactory
    {
        return $this->state(fn (array $attributes) => [ 'status' => Status::WAIT ]);
    }

    public function email(string $email): UserFactory
    {
        return $this->state(fn (array $attributes) => [ 'email' => $email ]);
    }

    public function id(string $id): UserFactory
    {
        return $this->state(fn (array $attributes) => [ 'id' => new Id($id) ]);
    }
}
