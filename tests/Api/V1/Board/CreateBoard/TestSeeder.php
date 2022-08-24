<?php
declare(strict_types=1);

namespace Tests\Api\V1\Board\CreateBoard;

use App\Domain\User\User;
use Illuminate\Database\Seeder;

final class TestSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()
            ->count(1)
            ->email('test@test.by')
            ->active()
            ->create();
    }
}
