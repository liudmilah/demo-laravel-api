<?php

namespace App\Http\Controllers\Api\V1\Board;

use App\Domain\Board\Command\Create\Command;
use App\Domain\Board\Command\Create\Handler;
use App\Http\Controllers\Controller;
use App\Http\Requests\Board\CreateBoardRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

/**
 * @OA\Post(
 *     path="/api/v1/board",
 *     tags={"Board"},
 *     summary="Adds a new board",
 *     @OA\RequestBody(ref="#/components/requestBodies/CreateBoardRequest"),
 *     @OA\Response(
 *         response=201,
 *         description="Success",
 *         @OA\JsonContent(
 *             @OA\Property(property="id", type="string"),
 *             @OA\Examples(example=201, value={"id": "123e4567-e89b-12d3-a456-426614174000"}, summary="Success example")
 *         )
 *     ),
 *     @OA\Response(
 *         response=422,
 *         description="Validation error",
 *         @OA\JsonContent(
 *              @OA\Property(property="message", type="string"),
 *              @OA\Property(
 *                  property="errors",
 *                  @OA\Schema(
 *                      type="array",
 *                      @OA\Items(type="string")
 *                  )
 *              ),
 *             @OA\Examples(example=422, value={"message": "Invalid board name", "errors": "one"}, summary="Validation error example")
 *         )
 *     )
 * )
 */
class CreateBoard extends Controller
{
    public function __invoke(CreateBoardRequest $request, Handler $handler, Response $response): JsonResponse
    {
        $validated = $request->validated();

        $user = \App\Domain\User\User::all()->first();

        $command = new Command($validated['name'], $user);

        $boardId = $handler->handle($command);

        return response()
            ->json(['id' => $boardId->getValue()])
            ->setStatusCode(201);
    }
}
