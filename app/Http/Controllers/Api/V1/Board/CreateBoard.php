<?php

namespace App\Http\Controllers\Api\V1\Board;

use App\Domain\Board\Command\Create\Command;
use App\Domain\Board\Command\Create\Handler;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

/**
 * @OA\Post(
 *     path="/api/v1/board",
 *     tags={"Board"},
 *     summary="Add a new board",
 *     @OA\RequestBody(
 *         @OA\JsonContent(
 *             @OA\Property(property="name", type="string")
 *         )
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="Success",
 *         @OA\JsonContent(
 *             @OA\Property(property="id", type="string"),
 *         )
 *     ),
 *     @OA\Response(
 *         response=422,
 *         description="Validation error",
 *         @OA\JsonContent(
 *              @OA\Property(property="message", type="string"),
 *         )
 *     )
 * )
 */
class CreateBoard extends Controller
{
    public function __invoke(Request $request, Handler $handler): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'bail|required|max:100'
        ]);

        $validator->validate();

        $user = \App\Domain\User\User::all()->first();

        $command = new Command($request->input('name'), $user);

        $boardId = $handler->handle($command);

        return response()
            ->json(['id' => $boardId->getValue()])
            ->setStatusCode(201);
    }
}

// todo that does not work:

//#[OA\Post(
//    path: '/api/v1/board',
//    tags: ['Board'],
//    summary: 'Adds a new board',
//    requestBody: new OA\RequestBody(
//        content: new OA\JsonContent(
//            properties: [
//                new OA\Property(property: 'string', name: 'name'),
//            ]
//        )
//    ),
//    responses: [
//        new OA\Response(
//            response: '201',
//            description: 'Success',
//            content: new OA\JsonContent(
//                properties: [
//                    new OA\Property(property: 'string', name: 'id')
//                ]
//            )
//        ),
//        new OA\Response(
//            response: '422',
//            description: 'Validation error',
//            content: new OA\JsonContent(
//                properties: [
//                    new OA\Property(property: 'string', name: 'message')
//                ]
//            )
//        ),
//    ]
//)]
