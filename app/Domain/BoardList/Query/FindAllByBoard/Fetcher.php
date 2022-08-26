<?php

namespace App\Domain\BoardList\Query\FindAllByBoard;

use Illuminate\Database\Connection;

final class Fetcher
{
    public function __construct(private Connection $connection) {}

    /**
     * @param Query $query
     * @return array<BoardList>
     */
    public function fetch(Query $query): array
    {
        $sql = <<<SQL
            SELECT lists.id, lists.name, lists.sequence
            FROM lists
            JOIN boards ON lists.board_id=boards.id
            WHERE boards.id=? AND boards.user_id=?
            ORDER BY lists.sequence
        SQL;

        $data = $this->connection->select($sql, [$query->boardId, $query->userId]);

        return array_map(
            fn (\stdClass $row) => new BoardList($row->id, $row->name, $row->sequence),
            $data
        );
    }
}
