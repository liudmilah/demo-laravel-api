<?php
declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Auth;

use App\Domain\User\Command\Login\Command;
use App\Domain\User\Command\Login\Handler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use OpenApi\Attributes as OA;

#[OA\Post(
    path: '/api/v1/auth/login',
    summary: 'Login user',
    requestBody: new OA\RequestBody(
        content: new OA\JsonContent(
            properties: [
                new OA\Property(property: 'email', type: 'string'),
                new OA\Property(property: 'password', type: 'string'),
            ]
        )
    ),
    tags: ['Auth'],
    responses: [
        new OA\Response(
            response: '200',
            description: 'Success',
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: 'token', type: 'string')
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
final class Login extends \App\Http\Controllers\Controller
{
    public function __invoke(Request $request, Handler $handler, Response $response): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => 'bail|required|email',
            'password' => 'bail|required',
        ]);

        $validator->validate();

        $command = new Command(
            email: $request->input('email'),
            password: $request->input('password'),
        );

        $user = $handler->handle($command);

        return response()
            ->json(['token' => $user->createToken('todo-device-name')->plainTextToken]);
    }
}
