<?php
declare(strict_types=1);

namespace Tests\Api\V1\Board\DeleteBoard;

use App\Domain\Board\Board;
use App\Domain\User\User;
use Illuminate\Database\Seeder;

final class TestSeeder extends Seeder
{
    public const USER_ID = 'dcfc204a-4c75-4152-8431-4d3f02e7af6d';
    public const BOARD_ID = 'dcfc204a-4c75-4152-8431-4d3f02e7af6a';

    public function run(): void
    {
        $userFactory = User::factory()
            ->id(self::USER_ID)
            ->active();

        Board::factory()
            ->count(1)
            ->for($userFactory)
            ->id(self::BOARD_ID)
            ->create();
    }
}
