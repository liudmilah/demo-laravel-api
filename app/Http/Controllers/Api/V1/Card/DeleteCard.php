<?php

namespace App\Http\Controllers\Api\V1\Card;

use App\Domain\Card\Command\Delete\Command;
use App\Domain\Card\Command\Delete\Handler;
use App\Domain\Id;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DeleteCard extends Controller
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
