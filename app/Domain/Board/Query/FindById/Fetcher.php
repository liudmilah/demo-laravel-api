<?php

namespace App\Domain\Board\Query\FindById;

use App\Exceptions\ItemNotFoundException;
use Illuminate\Database\Connection;

final class Fetcher
{
    public function __construct(private Connection $connection) {}

    public function fetch(Query $query): Board
    {
        $sql = 'SELECT id, name from boards WHERE id=? AND user_id=?';

        $data = $this->connection->selectOne($sql, [$query->boardId, $query->userId]);

        if (!$data) {
            throw new ItemNotFoundException();
        }

        return new Board($data->id, $data->name);
    }
}
