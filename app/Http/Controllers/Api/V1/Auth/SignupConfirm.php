<?php
declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Auth;

use Illuminate\Http\Request;
use App\Domain\User\Command\SignupConfirm\Command;
use App\Domain\User\Command\SignupConfirm\Handler;

final class SignupConfirm extends \App\Http\Controllers\Controller
{
    public function __invoke(Request $request, Handler $handler): void
    {
        $command = new Command(
            userId: $request->route('id'),
            hash: $request->route('hash'),
        );

        $handler->handle($command);
    }
}
