<?php
declare(strict_types=1);

namespace Tests\Api\V1\Auth\Login;

use App\Domain\User\User;
use Illuminate\Database\Seeder;

final class TestSeeder extends Seeder
{
    public const ACTIVE_USER_ID = 'dcfc204a-4c75-4152-8431-4d3f02e7af6d';
    public const ACTIVE_USER_EMAIL = 'active@test.by';

    public const WAITING_USER_ID = 'dcfc204a-4c75-4152-8431-4d3f02e7af6e';
    public const WAITING_USER_EMAIL = 'wait@test.by';

    public function run(): void
    {
        User::factory()
            ->count(1)
            ->email(self::WAITING_USER_EMAIL)
            ->id(self::WAITING_USER_ID)
            ->wait()
            ->create();

        User::factory()
            ->count(1)
            ->email(self::ACTIVE_USER_EMAIL)
            ->id(self::ACTIVE_USER_ID)
            ->active()
            ->create();
    }
}
