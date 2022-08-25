<?php
declare(strict_types=1);

namespace App\Domain\Board\Command\Delete;

use App\Domain\Board\Events\BoardDeleted;
use App\Exceptions\ItemNotFoundException;
use Illuminate\Contracts\Events\Dispatcher;
use App\Domain\Board\Board;
use App\Domain\Board\BoardRepository;
use App\Domain\Id;

final class Handler
{
    public function __construct(private BoardRepository $boards, private Dispatcher $dispatcher) {}

    public function handle(Command $command): void
    {
        $board = $this->assertBoardExists($command->boardId, $command->userId);

        $this->boards->delete($board);

        $this->dispatcher->dispatch(new BoardDeleted($board));
    }

    private function assertBoardExists(Id $boardId, Id $userId): Board
    {
        if (!$board = $this->boards->findOneByIdAndUser($boardId, $userId)) {
            throw new ItemNotFoundException();
        }

        return $board;
    }
}
