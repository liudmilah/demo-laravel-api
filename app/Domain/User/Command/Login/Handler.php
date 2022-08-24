<?php
declare(strict_types=1);

namespace App\Domain\User\Command\Login;

use App\Domain\User\Events\UserLoggedIn;
use App\Domain\User\User;
use App\Domain\User\UserRepository;
use Illuminate\Events\Dispatcher;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

final class Handler
{
    public function __construct(private UserRepository $users, private Dispatcher $dispatcher) {}

    public function handle(Command $command): User
    {
        $user = $this->assertActiveUserExists($command->email);

        $this->assertValidPassword($user, $command->password);

        $this->dispatcher->dispatch(new UserLoggedIn($user));

        return $user;
    }

    private function assertActiveUserExists(string $email): User
    {
        /** @var User $user */
        if (! $user = $this->users->findOneActiveByEmail($email)) {
            Log::warning('Login request: user does not exist with this email: ' . $email);
            throw new \DomainException('Invalid request data.');
        }

        return $user;
    }

    private function assertValidPassword(User $user, string $requestPasswordHash): void
    {
        if (! Hash::check($requestPasswordHash, $user->passwordHash)) {
            Log::warning('Login request: invalid password for this email: ' . $user->email);
            throw new \DomainException('Invalid request data.');
        }
    }
}
