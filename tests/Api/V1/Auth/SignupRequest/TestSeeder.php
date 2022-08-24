<?php
declare(strict_types=1);

namespace Tests\Api\V1\Auth\SignupRequest;

use App\Domain\User\User;
use Illuminate\Database\Seeder;

final class TestSeeder extends Seeder
{
    public const EMAIL = 'test@test.by';

    public function run(): void
    {
        User::factory()
            ->count(1)
            ->email(self::EMAIL)
            ->active()
            ->create();
    }
}
