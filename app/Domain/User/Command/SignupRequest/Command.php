<?php
declare(strict_types=1);

namespace App\Domain\User\Command\SignupRequest;


final class Command
{
    public function __construct(
        public string $name,
        public string $email,
        public string $password,
    ) {}
}
