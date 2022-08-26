<?php
declare(strict_types=1);

namespace App\Domain\BoardList\Command\Update;

use App\Domain\BoardList\BoardList;
use App\Domain\BoardList\BoardListRepository;
use App\Domain\Id;
use App\Domain\User\User;

final class Handler
{
    public function __construct(private readonly BoardListRepository $lists) {}

    public function handle(Command $command): void
    {
        $list = $this->assertListExists($command->listId, $command->boardId, $command->user);
        $this->assertSequenceIsUnique($list, $command->sequence, $command->boardId);
        $this->assertNameIsUnique($list, $command->name, $command->boardId);

        $list->name = $command->name;
        $list->sequence = $command->sequence;

        $this->lists->update($list);
    }

    private function assertListExists(Id $listId, Id $boardId, User $user): BoardList
    {
        if (!$list = $this->lists->findOne($listId, $boardId, $user->id)) {
            throw new \DomainException('List not found.');
        }

        return $list;
    }

    private function assertSequenceIsUnique(BoardList $list, int $sequence, Id $boardId): void
    {
        if ($list->sequence !== $sequence && $this->lists->hasBySequence($sequence, $boardId)) {
            throw new \DomainException('List with this sequence already exists.');
        }
    }

    private function assertNameIsUnique(BoardList $list, string $name, Id $boardId): void
    {
        if ($list->name !== $name && $this->lists->hasByName($name, $boardId)) {
            throw new \DomainException('List with this name already exists.');
        }
    }
}
