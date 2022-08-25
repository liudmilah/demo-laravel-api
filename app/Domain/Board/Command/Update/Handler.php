<?php
declare(strict_types=1);

namespace App\Domain\Board\Command\Update;

use App\Domain\Board\Events\BoardUpdated;
use Illuminate\Contracts\Events\Dispatcher;
use App\Domain\Board\Board;
use App\Domain\Board\BoardRepository;
use App\Domain\Id;

final class Handler
{
    public function __construct(private BoardRepository $boards, private Dispatcher $dispatcher) {}

    public function handle(Command $command): void
    {
        $this->assertBoardNameIsUnique($command->name, $command->userId);

        $board = $this->boards->findOneByIdAndUser($command->boardId, $command->userId);

        $board->name = $command->name;

        /**
         * @var Board $board
         */
        $board = $this->boards->update($board);

        $this->dispatcher->dispatch(new BoardUpdated($board));
    }

    private function assertBoardNameIsUnique(string $name, Id $userId): void
    {
        if ($this->boards->hasByName($name, $userId)) {
            throw new \DomainException('Board name is not unique.');
        }
    }
}
