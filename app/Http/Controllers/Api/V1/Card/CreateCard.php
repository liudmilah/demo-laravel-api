<?php

namespace App\Http\Controllers\Api\V1\Card;

use App\Domain\Card\Command\Create\Command;
use App\Domain\Card\Command\Create\Handler;
use App\Domain\Card\Card;
use App\Domain\Id;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CreateCard extends Controller
{
    public function __invoke(Request $request, Handler $handler): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:'.Card::NAME_LENGTH,
            'description' => 'max:'.Card::DESCR_LENGTH,
            'sequence' => 'required|integer',
            'listId' => 'required|uuid',
            'boardId' => 'required|uuid',
        ]);

        $validator->validate();

        $command = new Command(
            $request->input('name'),
            $request->input('description') ?? '',
            $request->input('sequence'),
            new Id($request->input('listId')),
            new Id($request->input('boardId')),
            $request->user()->id
        );

        $id = $handler->handle($command);

        return response()
            ->json(['id' => $id->getValue()])
            ->setStatusCode(201);
    }
}
