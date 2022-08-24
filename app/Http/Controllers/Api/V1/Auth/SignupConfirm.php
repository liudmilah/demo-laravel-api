<?php
declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Auth;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Domain\User\Command\SignupConfirm\Command;
use App\Domain\User\Command\SignupConfirm\Handler;

final class SignupConfirm extends \App\Http\Controllers\Controller
{
    public function __invoke(Request $request, Handler $handler): JsonResponse
    {
        $command = new Command(
            userId: $request->route('id'),
            hash: $request->route('hash'),
        );

        $user = $handler->handle($command);

        return response()
            ->json(['token' => $user->createToken('todo-device-name')->plainTextToken]);
    }
}
