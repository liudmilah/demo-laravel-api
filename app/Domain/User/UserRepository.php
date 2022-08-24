<?php
declare(strict_types=1);

namespace App\Domain\User;

use App\Domain\BaseRepository;

final class UserRepository extends BaseRepository
{
    protected static string $modelClass = User::class;

    public function findOneByEmail(string $email): ?User
    {
        return User::where('email', $email)->first();
    }

    public function findOneWaitingById(string $id): ?User
    {
        return User::where('id', $id)
            ->where('status', Status::WAIT->value)
            ->first();
    }
}
