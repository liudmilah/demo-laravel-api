<?php

namespace App\Http\Controllers\Api\V1\BoardList;

use App\Domain\BoardList\Query\FindById\Query;
use App\Domain\BoardList\Query\FindById\Fetcher;
use App\Domain\Id;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GetList extends Controller
{
    public function __invoke(Request $request, Fetcher $boards): array
    {
        $query = new Query(new Id($request->route('id')), $request->user()->id);

        $boardList = $boards->fetch($query);

        return [
            'id' => $boardList->id,
            'name' => $boardList->name,
            'sequence' => $boardList->sequence,
        ];
    }
}
