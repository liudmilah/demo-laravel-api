<?php
declare(strict_types=1);

namespace App\Domain\Board\Events;

use App\Domain\Board\Board;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

final class BoardCreated
{
    use Dispatchable, SerializesModels;

    public function __construct(public Board $board) { }
}
