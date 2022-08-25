<?php

namespace App\Http\Controllers\Api\V1\Board;

use App\Domain\Board\Query\FindById\Query;
use App\Domain\Board\Query\FindById\Fetcher;
use App\Domain\Id;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GetBoard extends Controller
{
    public function __invoke(Request $request, Fetcher $boards): array
    {
        $query = new Query(new Id($request->route('id')), $request->user()->id);

        $board = $boards->fetch($query);

        return [
            'id' => $board->id,
            'name' => $board->name,
        ];
    }
}
