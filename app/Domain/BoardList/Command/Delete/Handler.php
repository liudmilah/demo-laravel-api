<?php
declare(strict_types=1);

namespace App\Domain\BoardList\Command\Delete;

use App\Domain\BoardList\BoardList;
use App\Exceptions\ItemNotFoundException;
use App\Domain\BoardList\BoardListRepository;
use App\Domain\Id;

final class Handler
{
    public function __construct(private BoardListRepository $lists) {}

    public function handle(Command $command): void
    {
        $boardList = $this->assertBoardListExists($command->listId, $command->userId);

        $this->lists->delete($boardList);
    }

    private function assertBoardListExists(Id $listId, Id $userId): BoardList
    {
        if (!$boardList = $this->lists->findOneByIdAndUser($listId, $userId)) {
            throw new ItemNotFoundException();
        }

        return $boardList;
    }
}
