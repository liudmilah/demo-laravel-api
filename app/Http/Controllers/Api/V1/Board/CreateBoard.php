<?php

namespace App\Http\Controllers\Api\V1\Board;

use App\Domain\Board\Board;
use App\Domain\Board\Command\Create\Command;
use App\Domain\Board\Command\Create\Handler;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use OpenApi\Attributes as OA;

#[OA\Post(
    path: '/api/v1/board',
    summary: 'Adds a new board',
    requestBody: new OA\RequestBody(
        content: new OA\JsonContent(
            properties: [
                new OA\Property(property: 'name', type: 'string'),
            ]
        )
    ),
    tags: ['Board'],
    responses: [
        new OA\Response(
            response: '201',
            description: 'Success',
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: 'id', type: 'string')
                ]
            )
        ),
        new OA\Response(
            response: '422',
            description: 'Validation error',
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: 'message', type: 'string')
                ]
            )
        ),
    ]
)]
class CreateBoard extends Controller
{
    public function __invoke(Request $request, Handler $handler): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:'.Board::NAME_LENGTH,
        ]);

        $validator->validate();

        $command = new Command($request->input('name'), $request->user());

        $boardId = $handler->handle($command);

        return response()
            ->json(['id' => $boardId->getValue()])
            ->setStatusCode(201);
    }
}
