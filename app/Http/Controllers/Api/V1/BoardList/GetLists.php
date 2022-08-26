<?php

namespace App\Http\Controllers\Api\V1\BoardList;

use App\Domain\BoardList\Query\FindAllByBoard\BoardList;
use App\Domain\BoardList\Query\FindAllByBoard\Query;
use App\Domain\BoardList\Query\FindAllByBoard\Fetcher;
use App\Domain\Id;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class GetLists extends Controller
{
    public function __invoke(Request $request, Fetcher $boards): array
    {
        $validator = Validator::make($request->all(), [
            'boardId' => 'required|uuid',
        ]);

        $validator->validate();

        $query = new Query(
            new Id($request->query('boardId')),
            $request->user()->id
        );

        $lists = $boards->fetch($query);

        return array_map(
            fn (BoardList $list) => [
                'id' => $list->id,
                'name' => $list->name,
                'sequence' => $list->sequence,
            ],
            $lists
        );
    }
}
