<?php

namespace App\Domain\Card\Query\FindAllByBoard;

use Illuminate\Database\Connection;

final class Fetcher
{
    public function __construct(private Connection $connection) {}

    /**
     * @param Query $query
     * @return array<Card>
     */
    public function fetch(Query $query): array
    {
        $sql = <<<SQL
            SELECT cards.id, cards.name, cards.description, cards.sequence, cards.list_id
            FROM cards
            JOIN lists ON cards.list_id = lists.id
            JOIN boards ON lists.board_id=boards.id
            WHERE lists.board_id=? AND boards.user_id=?
            ORDER BY lists.sequence, cards.sequence
        SQL;

        $data = $this->connection->select($sql, [$query->boardId, $query->userId]);

        return array_map(
            fn (\stdClass $row) => new Card($row->id, $row->name, $row->description, $row->sequence, $row->list_id),
            $data
        );
    }
}
