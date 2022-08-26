<?php
declare(strict_types=1);

namespace Tests\Api\V1\Card\GetCards;

use App\Domain\Board\Board;
use App\Domain\BoardList\BoardList;
use App\Domain\Card\Card;
use App\Domain\User\User;
use Illuminate\Database\Seeder;

final class TestSeeder extends Seeder
{
    public const USER_ID = 'dcfc204a-4c75-4152-8431-4d3f02e7af6d';
    public const BOARD_ID = 'dcfc204a-4c75-4152-8431-4d3f02e7af6a';

    // lists
    public const LIST1_ID = 'dcfc204a-4c75-4152-8431-4d3f02e7a000';
    public const LIST1_NAME = 'Todo';
    public const LIST1_SEQ = 1;

    public const LIST2_ID = 'dcfc204a-4c75-4152-8431-4d3f02e7a111';
    public const LIST2_NAME = 'In progress';
    public const LIST2_SEQ = 2;

    // cards
    public const CARD1_ID = 'dcfc204a-4c75-4152-8431-4d3f02e11111';
    public const CARD1_NAME = 'Card 1 name';
    public const CARD1_DESCR = 'Card 1 description';
    public const CARD1_SEQ = 1;

    public const CARD2_ID = 'dcfc204a-4c75-4152-8431-4d3f02e22222';
    public const CARD2_NAME = 'Card 2 name';
    public const CARD2_DESCR = 'Card 2 description';
    public const CARD2_SEQ = 2;

    public const CARD3_ID = 'dcfc204a-4c75-4152-8431-4d3f02e33333';
    public const CARD3_NAME = 'Card 3 name';
    public const CARD3_DESCR = 'Card 3 description';
    public const CARD3_SEQ = 3;

    public function run(): void
    {
        $userFactory = User::factory()
            ->id(self::USER_ID)
            ->active();

        // cards
        $card1 = Card::factory()
            ->id(self::CARD1_ID)
            ->name(self::CARD1_NAME)
            ->description(self::CARD1_DESCR)
            ->sequenceNumber(self::CARD1_SEQ);
        $card2 = Card::factory()
            ->id(self::CARD2_ID)
            ->name(self::CARD2_NAME)
            ->description(self::CARD2_DESCR)
            ->sequenceNumber(self::CARD2_SEQ);
        $card3 = Card::factory()
            ->id(self::CARD3_ID)
            ->name(self::CARD3_NAME)
            ->description(self::CARD3_DESCR)
            ->sequenceNumber(self::CARD3_SEQ);

        // lists
        $list1 = BoardList::factory()
            ->id(self::LIST1_ID)
            ->name(self::LIST1_NAME)
            ->sequenceNumber(self::LIST1_SEQ)
            ->has($card1)
            ->has($card2);
        $list2 = BoardList::factory()
            ->id(self::LIST2_ID)
            ->name(self::LIST2_NAME)
            ->sequenceNumber(self::LIST2_SEQ)
            ->has($card3);

        // board
        Board::factory()
            ->for($userFactory)
            ->id(self::BOARD_ID)
            ->has($list1)
            ->has($list2)
            ->create();
    }
}
