<?php
declare(strict_types=1);

namespace Tests\Api\V1\Auth\SignupConfirm;

use App\Domain\Id;
use App\Domain\User\User;
use Illuminate\Database\Seeder;

final class TestSeeder extends Seeder
{
    public const ACTIVE_USER_ID = 'dcfc204a-4c75-4152-8431-4d3f02e7af6d';
    public const WAIT_USER_ID = 'dcfc204a-4c75-4152-8431-4d3f02e7af6e';

    public function run(): void
    {
        User::factory()
            ->count(1)
            ->email('wait@test.by')
            ->id(new Id(self::WAIT_USER_ID))
            ->wait()
            ->create();

        User::factory()
            ->count(1)
            ->email('active@test.by')
            ->id(new Id(self::ACTIVE_USER_ID))
            ->active()
            ->create();
    }
}
