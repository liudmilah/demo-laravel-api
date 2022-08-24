<?php
declare(strict_types=1);

namespace App\Domain\User\Command\Login;


final class Command
{
    public function __construct(
        public string $email,
        public string $password,
    ) {}
}
