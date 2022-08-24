<?php
declare(strict_types=1);

namespace App\Domain\User\Command\SignupRequest;

use App\Domain\Id;
use App\Domain\User\Events\UserRegistered;
use App\Domain\User\User;
use App\Domain\User\UserRepository;
use Illuminate\Events\Dispatcher;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;

final class Handler
{
    public function __construct(private UserRepository $users, private Dispatcher $dispatcher) {}

    public function handle(Command $command): void
    {
        $this->assertUserDoesntExist($command->email);

        $user = User::signup(
            Id::generate(),
            $command->name,
            $command->email,
            Hash::make($command->password)
        );

        /**
         * @var User $user
         */
        $user = $this->users->add($user);

        $this->dispatcher->dispatch(new UserRegistered($user));
    }

    private function assertUserDoesntExist(string $email)
    {
        if ($this->users->findOneByEmail($email) !== null) {
            Log::warning('Signup request: user exists with this email: ' . $email);
            throw new \DomainException('Invalid request data.');
        }
    }
}
