<?php
declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Auth;

use App\Domain\User\Command\Login\Command;
use App\Domain\User\Command\Login\Handler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

/**
 * @OA\Post(
 *     path="/api/v1/auth/login",
 *     tags={"Auth"},
 *     summary="Login user",
 *     @OA\RequestBody(
 *         @OA\JsonContent(
 *             @OA\Property(property="email", type="string"),
 *             @OA\Property(property="password", type="string"),
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Success",
 *         @OA\JsonContent(
 *              @OA\Property(property="token", type="string")
 *         )
 *     ),
 *     @OA\Response(
 *         response=422,
 *         description="Validation error",
 *         @OA\JsonContent(
 *              @OA\Property(property="message", type="string")
 *         )
 *     )
 * )
 */
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
