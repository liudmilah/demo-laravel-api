<?php
declare(strict_types=1);

namespace Tests\Api\V1\BoardList\GetList;

use App\Domain\BoardList\BoardList;
use App\Domain\User\User;
use App\Domain\Board\Board;
use Illuminate\Database\Seeder;

final class TestSeeder extends Seeder
{
    public const USER_ID = 'dcfc204a-4c75-4152-8431-4d3f02e7af6d';
    public const BOARD_ID = 'dcfc204a-4c75-4152-8431-4d3f02e7af6a';
    public const LIST_ID = 'dcfc204a-4c75-4152-8431-4d3f02e7a000';
    public const LIST_NAME = 'Todo';
    public const LIST_SEQ = 1;

    public function run(): void
    {
        $userFactory = User::factory()
            ->id(self::USER_ID)
            ->active();

        $boardFactory = Board::factory()
            ->for($userFactory)
            ->id(self::BOARD_ID);

        BoardList::factory()
            ->for($boardFactory)
            ->id(self::LIST_ID)
            ->name(self::LIST_NAME)
            ->sequenceNumber(self::LIST_SEQ)
            ->create();
    }
}
