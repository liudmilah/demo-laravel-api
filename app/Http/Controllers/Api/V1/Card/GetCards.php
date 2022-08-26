<?php

namespace App\Http\Controllers\Api\V1\Card;

use App\Domain\Card\Query\FindAllByBoard\Query;
use App\Domain\Card\Query\FindAllByBoard\Fetcher;
use App\Domain\Id;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class GetCards extends Controller
{
    public function __invoke(Request $request, Fetcher $cards): array
    {
        $validator = Validator::make($request->all(), [
            'boardId' => 'required|uuid',
        ]);

        $validator->validate();

        $query = new Query(
            new Id($request->query('boardId')),
            $request->user()->id
        );

        $boardCards = $cards->fetch($query);

        $result = [];
        foreach ($boardCards as $card) {
            $result[$card->listId][] = [
                'id' => $card->id,
                'name' => $card->name,
                'description' => $card->description,
                'sequence' => $card->sequence,
            ];
        }

        return $result;
    }
}
