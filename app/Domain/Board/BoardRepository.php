<?php
declare(strict_types=1);

namespace App\Domain\Board;

use App\Domain\BaseRepository;
use App\Domain\Id;

final class BoardRepository extends BaseRepository
{
    protected static string $modelClass = Board::class;

    public function findOneByIdAndUser(Id $boardId, Id $userId): ?Board
    {
        return Board::where('id', $boardId)
            ->where('user_id', $userId)
            ->first();
    }

    public function hasByIdAndUser(Id $boardId, Id $userId): bool
    {
        return Board::where('id', $boardId)
            ->where('user_id', $userId)
            ->exists();
    }

    public function hasByName(string $name, Id $userId): bool
    {
        return Board::where('name', $name)
            ->where('user_id', $userId)
            ->exists();
    }
}
