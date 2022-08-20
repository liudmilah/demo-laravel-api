<?php
declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Domain\User\User;

class UsersSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()
            ->count(3)
            ->create();
    }
}
