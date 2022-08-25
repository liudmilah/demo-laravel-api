<?php

namespace App\Http\Controllers\Api\V1\Board;

use App\Domain\Board\Command\Delete\Command;
use App\Domain\Board\Command\Delete\Handler;
use App\Domain\Id;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DeleteBoard extends Controller
{
    public function __invoke(Request $request, Handler $handler): void
    {
        $command = new Command(
            new Id($request->route('id')),
            $request->user()->id
        );

        $handler->handle($command);
    }
}
