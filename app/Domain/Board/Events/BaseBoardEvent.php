<?php

namespace App\Domain\Board\Events;

use App\Domain\Board\Board;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

abstract class BaseBoardEvent implements ShouldBroadcast
{
    use Dispatchable, SerializesModels, InteractsWithSockets;

    public string $connection = 'redis';

    public function __construct(public Board $board) {}

    public function broadcastOn(): Channel
    {
        return new PrivateChannel("boards.{$this->board->id->getValue()}");
    }
}
