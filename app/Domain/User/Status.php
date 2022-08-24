<?php
declare(strict_types=1);

namespace App\Domain\User;

enum Status: string
{
    case WAIT = 'wait';
    case ACTIVE = 'active';
}

