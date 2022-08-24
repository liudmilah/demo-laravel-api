<?php

use App\Domain\Id;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('boards.{boardId}', function ($user, $boardId, \App\Domain\Board\BoardRepository $boards) {
    /**
     * @var \App\Domain\Board\Board $board
     */
    $board = $boards->findOneById(new Id($boardId));

    return $board && $user->id === $board->user->id->getValue();
});
