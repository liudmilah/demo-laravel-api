<?php
declare(strict_types=1);

namespace App\Domain\BoardList;

use App\Domain\BaseRepository;
use App\Domain\Id;

final class BoardListRepository extends BaseRepository
{
    protected static string $modelClass = BoardList::class;

    public function findOneByIdAndUser(Id $listId, Id $userId): ?BoardList
    {
        return BoardList::select(['lists.*'])
            ->join('boards', 'boards.id', '=', 'lists.board_id')
            ->where('boards.user_id', $userId)
            ->where('lists.id', $listId)
            ->first();
    }

    public function findOne(Id $listId, Id $boardId, Id $userId): ?BoardList
    {
        return BoardList::select(['lists.*'])
            ->join('boards', 'boards.id', '=', 'lists.board_id')
            ->where('boards.user_id', $userId)
            ->where('boards.id', $boardId)
            ->where('lists.id', $listId)
            ->first();
    }

    public function hasByName(string $name, Id $boardId): bool
    {
        return BoardList::where('name', $name)
            ->where('board_id', $boardId)
            ->exists();
    }

    public function hasBySequence(int $sequence, Id $boardId): bool
    {
        return BoardList::where('sequence', $sequence)
            ->where('board_id', $boardId)
            ->exists();
    }
}
