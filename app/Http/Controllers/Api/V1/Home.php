<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;

class Home extends Controller
{
    public function __invoke(): array
    {
        return [ 'success' => true ];
    }
}
