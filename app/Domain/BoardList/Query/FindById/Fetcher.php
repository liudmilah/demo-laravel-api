<?php

namespace App\Domain\BoardList\Query\FindById;

use App\Exceptions\ItemNotFoundException;
use Illuminate\Database\Connection;

final class Fetcher
{
    public function __construct(private Connection $connection) {}

    public function fetch(Query $query): BoardList
    {
        $sql = 'SELECT lists.id, lists.name, lists.sequence FROM lists JOIN boards ON lists.board_id=boards.id WHERE lists.id=? AND boards.user_id=?';

        $data = $this->connection->selectOne($sql, [$query->listId, $query->userId]);

        if (!$data) {
            throw new ItemNotFoundException();
        }

        return new BoardList($data->id, $data->name, $data->sequence);
    }
}
