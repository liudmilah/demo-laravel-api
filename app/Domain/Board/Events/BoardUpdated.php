<?php
declare(strict_types=1);

namespace App\Domain\Board\Events;

use App\Domain\Board\Board;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

final class BoardUpdated implements ShouldBroadcast
{
    use Dispatchable, SerializesModels, InteractsWithSockets;

    public string $connection = 'redis';

    public function __construct(public Board $board) {}

    public function broadcastOn(): Channel
    {
        return new PrivateChannel("boards.{$this->board->id->getValue()}");
    }

    public function broadcastAs(): string
    {
        return 'board.updated';
    }
}
