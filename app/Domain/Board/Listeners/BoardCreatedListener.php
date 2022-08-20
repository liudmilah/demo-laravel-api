<?php
declare(strict_types=1);

namespace App\Domain\Board\Listeners;

use App\Domain\Board\Events\BoardCreated;

final class BoardCreatedListener
{
    public function handle(BoardCreated $event): void
    {
        $board = $event->board;
        // todo broadcast
    }
}
