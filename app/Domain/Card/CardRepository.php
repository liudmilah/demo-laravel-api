<?php
declare(strict_types=1);

namespace App\Domain\Card;

use App\Domain\BaseRepository;
use App\Domain\Id;

final class CardRepository extends BaseRepository
{
    protected static string $modelClass = Card::class;

    public function findOne(Id $cardId, Id $listId, Id $boardId, Id $userId): ?Card
    {
        return Card::select(['cards.*'])
            ->join('lists', 'lists.id', '=', 'cards.list_id')
            ->join('boards', 'boards.id', '=', 'lists.board_id')
            ->where('boards.user_id', $userId)
            ->where('boards.id', $boardId)
            ->where('lists.id', $listId)
            ->where('cards.id', $cardId)
            ->first();
    }

    public function findOneByIdAndUser(Id $cardId, Id $userId): ?Card
    {
        return Card::select(['cards.*'])
            ->join('lists', 'lists.id', '=', 'cards.list_id')
            ->join('boards', 'boards.id', '=', 'lists.board_id')
            ->where('boards.user_id', $userId)
            ->where('cards.id', $cardId)
            ->first();
    }

    public function hasByName(string $name, Id $boardId): bool
    {
        return Card::where('cards.name', $name)
            ->join('lists', 'cards.list_id', '=', 'lists.id')
            ->where('lists.board_id', $boardId)
            ->exists();
    }

    public function hasBySequence(int $sequence, Id $listId): bool
    {
        return Card::where('sequence', $sequence)
            ->where('list_id', $listId)
            ->exists();
    }
}
