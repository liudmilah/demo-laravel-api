<?php
declare(strict_types=1);

namespace Tests\Api\V1\Card\CreateCard;

use App\Domain\Board\Board;
use App\Domain\BoardList\BoardList;
use App\Domain\Card\Card;
use App\Domain\User\User;
use Illuminate\Database\Seeder;

final class TestSeeder extends Seeder
{
    public const USER_ID = 'dcfc204a-4c75-4152-8431-4d3f02e7af6d';
    public const BOARD_ID = 'dcfc204a-4c75-4152-8431-4d3f02e7af6a';

    public const LIST_ID = 'dcfc204a-4c75-4152-8431-4d3f02e7a000';
    public const LIST_NAME = 'Todo';
    public const LIST_SEQ = 1;

    public const CARD_ID = 'dcfc204a-4c75-4152-8431-4d3f02e11111';
    public const CARD_NAME = 'Card 1 name';
    public const CARD_DESCR = 'Card 1 description';
    public const CARD_SEQ = 1;

    public function run(): void
    {
        $card = Card::factory()
            ->id(self::CARD_ID)
            ->name(self::CARD_NAME)
            ->description(self::CARD_DESCR)
            ->sequenceNumber(self::CARD_SEQ);

        $list = BoardList::factory()
            ->id(self::LIST_ID)
            ->name(self::LIST_NAME)
            ->sequenceNumber(self::LIST_SEQ)
            ->has($card);

        $board = Board::factory()
            ->id(self::BOARD_ID)
            ->has($list);

        User::factory()
            ->id(self::USER_ID)
            ->active()
            ->has($board)
            ->create();
    }
}
