<?php
declare(strict_types=1);

namespace App\Domain\User\Command\SignupConfirm;


final class Command
{
    public function __construct(
        public string $userId,
        public string $hash,
    ) {}
}
