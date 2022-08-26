<?php
declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Auth;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Domain\User\Command\SignupRequest\Command;
use App\Domain\User\Command\SignupRequest\Handler;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use OpenApi\Attributes as OA;

#[OA\Post(
    path: '/api/v1/auth/signup',
    summary: 'Register a new user',
    requestBody: new OA\RequestBody(
        content: new OA\JsonContent(
            properties: [
                new OA\Property(property: 'name', type: 'string'),
                new OA\Property(property: 'email', type: 'string'),
                new OA\Property(property: 'password', type: 'string'),
                new OA\Property(property: 'password_confirmation', type: 'string'),
            ]
        )
    ),
    tags: ['Auth'],
    responses: [
        new OA\Response(
            response: '201',
            description: 'Success'
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
final class SignupRequest extends \App\Http\Controllers\Controller
{
    public function __invoke(Request $request, Handler $handler, Response $response): Response
    {
        $validator = Validator::make($request->all(), [
            'name' => 'bail|required|min:2|max:100',
            'email' => 'bail|required|unique:users|email',
            'password' => ['bail', 'required', 'confirmed', Password::min(8)],
        ]);

        $validator->validate();

        $command = new Command(
            name: $request->input('name'),
            email: $request->input('email'),
            password: $request->input('password'),
        );

        $handler->handle($command);

        return $response->setStatusCode(201);
    }
}
