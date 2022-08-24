<?php
declare(strict_types=1);

namespace Tests\Api\V1\Auth\Logout;

use App\Domain\User\User;
use Illuminate\Database\Seeder;

final class TestSeeder extends Seeder
{
    public const USER_ID = 'dcfc204a-4c75-4152-8431-4d3f02e7af6d';

    public function run(): void
    {
        User::factory()
            ->count(1)
            ->id(self::USER_ID)
            ->active()
            ->create();
    }
}
