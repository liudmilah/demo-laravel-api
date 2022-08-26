<?php

namespace App\Http\Controllers\Api\V1\BoardList;

use App\Domain\BoardList\Command\Delete\Command;
use App\Domain\BoardList\Command\Delete\Handler;
use App\Domain\Id;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DeleteList extends Controller
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
