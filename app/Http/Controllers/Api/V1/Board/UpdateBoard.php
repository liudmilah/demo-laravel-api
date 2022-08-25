<?php

namespace App\Http\Controllers\Api\V1\Board;

use App\Domain\Board\Board;
use App\Domain\Board\Command\Update\Command;
use App\Domain\Board\Command\Update\Handler;
use App\Domain\Id;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UpdateBoard extends Controller
{
    public function __invoke(Request $request, Handler $handler): void
    {
        $validator = Validator::make($request->all(), [
            'name' => ['bail', 'required', 'max:'.Board::NAME_LENGTH],
        ]);

        $validator->validate();

        $command = new Command(
            new Id($request->route('id')),
            $request->user()->id,
            $request->input('name')
        );

        $handler->handle($command);
    }
}

