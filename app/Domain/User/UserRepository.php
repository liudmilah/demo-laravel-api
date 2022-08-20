<?php
declare(strict_types=1);

namespace App\Domain\User;

use App\Domain\BaseRepository;

final class UserRepository extends BaseRepository
{
    protected static string $modelClass = User::class;
}
