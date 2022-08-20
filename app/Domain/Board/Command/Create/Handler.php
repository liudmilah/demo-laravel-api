<?php
declare(strict_types=1);

namespace App\Domain\Board\Command\Create;

use App\Domain\Board\Events\BoardCreated;
use Illuminate\Contracts\Events\Dispatcher;
use App\Domain\Board\Board;
use App\Domain\Board\BoardRepository;
use App\Domain\Id;

final class Handler
{
    public function __construct(private BoardRepository $boards, private Dispatcher $dispatcher) {}

    public function handle(Command $command): Id
    {
        $board = new Board([
            'id' => $id = Id::generate(),
            'name' => $command->name,
            'user_id' => $command->user->id->getValue(),
        ]);

        /**
         * @var Board $board
         */
        $board = $this->boards->add($board);

        $this->dispatcher->dispatch(new BoardCreated($board));

        return $id;
    }
}
