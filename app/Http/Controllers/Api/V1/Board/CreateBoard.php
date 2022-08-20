<?php

namespace App\Http\Controllers\Api\V1\Board;

use App\Domain\Board\Command\Create\Command;
use App\Domain\Board\Command\Create\Handler;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

class CreateBoard extends Controller
{
    public function __invoke(Request $request, Handler $handler, Response $response): JsonResponse
    {
        $request->validate([
            'name' => 'bail|required|max:100', // todo unique
        ]);

        $user = \App\Domain\User\User::all()->first();

        $command = new Command($request->input('name'), $user);

        $boardId = $handler->handle($command);

        return response()
            ->json(['id' => $boardId->getValue()])
            ->setStatusCode(201);
    }
}
