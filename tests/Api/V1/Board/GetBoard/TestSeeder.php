<?php
declare(strict_types=1);

namespace Tests\Api\V1\Board\GetBoard;

use App\Domain\Board\Board;
use App\Domain\User\User;
use Illuminate\Database\Seeder;

final class TestSeeder extends Seeder
{
    public const USER_ID = 'dcfc204a-4c75-4152-8431-4d3f02e7afdd';
    public const BOARD_ID = 'dcfc204a-4c75-4152-8431-4d3f02e7afaa';
    public const BOARD_NAME = 'My first board';

    public function run(): void
    {
        $userFactory = User::factory()
            ->id(self::USER_ID)
            ->active();

        Board::factory()
            ->count(1)
            ->for($userFactory)
            ->id(self::BOARD_ID)
            ->name(self::BOARD_NAME)
            ->create();
    }
}
