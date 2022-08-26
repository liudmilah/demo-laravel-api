<?php

namespace App\Http\Controllers\Api\V1\BoardList;

use App\Domain\BoardList\BoardList;
use App\Domain\BoardList\Command\Create\Command;
use App\Domain\BoardList\Command\Create\Handler;
use App\Domain\Id;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class CreateList extends Controller
{
    public function __invoke(Request $request, Handler $handler): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:'.BoardList::NAME_LENGTH,
            'boardId' => 'required|uuid',
            'sequence' => 'required|integer',
        ]);

        $validator->validate();

        $command = new Command(
            $request->input('name'),
            $request->input('sequence'),
            new Id($request->input('boardId')),
            $request->user()
        );

        $listId = $handler->handle($command);

        return response()
            ->json(['id' => $listId->getValue()])
            ->setStatusCode(201);
    }
}
