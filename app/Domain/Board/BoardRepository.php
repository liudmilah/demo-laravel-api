<?php
declare(strict_types=1);

namespace App\Domain\Board;

use App\Domain\BaseRepository;

final class BoardRepository extends BaseRepository
{
    protected static string $modelClass = Board::class;
}
