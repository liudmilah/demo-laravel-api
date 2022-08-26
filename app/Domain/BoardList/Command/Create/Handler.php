<?php
declare(strict_types=1);

namespace App\Domain\BoardList\Command\Create;

use App\Domain\Board\BoardRepository;
use App\Domain\BoardList\BoardList;
use App\Domain\BoardList\BoardListRepository;
use App\Domain\Id;
use App\Domain\User\User;

final class Handler
{
    public function __construct(private BoardListRepository $lists, private BoardRepository $boards) {}

    public function handle(Command $command): Id
    {
        $this->assertBoardExists($command->boardId, $command->user);
        $this->assertSequenceIsUnique($command->sequence, $command->boardId);
        $this->assertNameIsUnique($command->name, $command->boardId);

        $boardList = new BoardList([
            'id' => $id = Id::generate(),
            'name' => $command->name,
            'sequence' => $command->sequence,
            'board_id' => $command->boardId,
        ]);

        $this->lists->add($boardList);

        return $id;
    }

    private function assertBoardExists(Id $boardId, User $user): void
    {
        if (!$this->boards->hasByIdAndUser($boardId, $user->id)) {
            throw new \DomainException('Board not found.');
        }
    }

    private function assertSequenceIsUnique(int $sequence, Id $boardId): void
    {
        if ($this->lists->hasBySequence($sequence, $boardId)) {
            throw new \DomainException('List with this sequence already exists.');
        }
    }

    private function assertNameIsUnique(string $name, Id $boardId): void
    {
        if ($this->lists->hasByName($name, $boardId)) {
            throw new \DomainException('List with this name already exists.');
        }
    }
}
