<?php
declare(strict_types=1);

namespace Tests\Api\V1\BoardList\GetLists;

use App\Domain\BoardList\BoardList;
use App\Domain\Board\Board;
use App\Domain\User\User;
use Illuminate\Database\Seeder;

final class TestSeeder extends Seeder
{
    public const USER_ID = 'dcfc204a-4c75-4152-8431-4d3f02e7af6d';
    public const BOARD_ID = 'dcfc204a-4c75-4152-8431-4d3f02e7af6a';

    public const LIST1_ID = 'dcfc204a-4c75-4152-8431-4d3f02e7a000';
    public const LIST1_NAME = 'Todo';
    public const LIST1_SEQ = 1;

    public const LIST2_ID = 'dcfc204a-4c75-4152-8431-4d3f02e7a111';
    public const LIST2_NAME = 'In progress';
    public const LIST2_SEQ = 2;

    public function run(): void
    {
        $userFactory = User::factory()
            ->id(self::USER_ID)
            ->active();

        $list1 = BoardList::factory()
            ->id(self::LIST1_ID)
            ->name(self::LIST1_NAME)
            ->sequenceNumber(self::LIST1_SEQ);

        $list2 = BoardList::factory()
            ->id(self::LIST2_ID)
            ->name(self::LIST2_NAME)
            ->sequenceNumber(self::LIST2_SEQ);

        Board::factory()
            ->for($userFactory)
            ->id(self::BOARD_ID)
            ->has($list1)
            ->has($list2)
            ->create();
    }
}
