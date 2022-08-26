<?php

namespace App\Http\Controllers\Api\V1\Card;

use App\Domain\Card\Command\Update\Command;
use App\Domain\Card\Command\Update\Handler;
use App\Domain\Card\Card;
use App\Domain\Id;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UpdateCard extends Controller
{
    public function __invoke(Request $request, Handler $handler): void
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
            new Id($request->route('id')),
            $request->input('name'),
            $request->input('description') ?? '',
            $request->input('sequence'),
            new Id($request->input('listId')),
            new Id($request->input('boardId')),
            $request->user()->id
        );

        $handler->handle($command);
    }
}

