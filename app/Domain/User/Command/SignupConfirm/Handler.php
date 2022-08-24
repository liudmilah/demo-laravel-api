<?php
declare(strict_types=1);

namespace App\Domain\User\Command\SignupConfirm;

use App\Domain\User\User;
use App\Domain\User\UserRepository;

final class Handler
{
    public function __construct(private UserRepository $users) {}

    /**
     * todo improve
     */
    public function handle(Command $command)
    {
        $user = $this->assertUserExists($command->userId);
        $this->assertTokenValid($command->hash, $user);

        $user->signupConfirm();

        $user->markEmailAsVerified();

        $this->users->update($user);
    }

    private function assertUserExists($userId): User
    {
        /**
         * @var User $user
         */
        $user = $this->users->findOneWaitingById($userId);

        if (!$user) {
            throw new \DomainException('Invalid request data.');
        }

        return $user;
    }

    private function assertTokenValid(string $hash, User $user): void
    {
        if (! hash_equals($hash, sha1($user->getEmailForVerification()))) {
            throw new \DomainException('Invalid request data.');
        }
    }
}
