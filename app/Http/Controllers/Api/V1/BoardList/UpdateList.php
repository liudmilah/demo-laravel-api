<?php

namespace App\Http\Controllers\Api\V1\BoardList;

use App\Domain\BoardList\Command\Update\Command;
use App\Domain\BoardList\Command\Update\Handler;
use App\Domain\BoardList\BoardList;
use App\Domain\Id;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UpdateList extends Controller
{
    public function __invoke(Request $request, Handler $handler): void
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:'.BoardList::NAME_LENGTH,
            'boardId' => 'required|uuid',
            'sequence' => 'required|integer',
        ]);

        $validator->validate();

        $command = new Command(
            new Id($request->route('id')),
            $request->input('name'),
            $request->input('sequence'),
            new Id($request->input('boardId')),
            $request->user()
        );

        $handler->handle($command);
    }
}

