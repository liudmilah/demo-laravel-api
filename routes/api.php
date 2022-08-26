<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\{
    Auth\SignupRequest,
    Auth\SignupConfirm,
    Auth\Login,
    Auth\Logout,

    Board\CreateBoard,
    Board\UpdateBoard,
    Board\GetBoard,
    Board\DeleteBoard,

    BoardList\GetList,
    BoardList\GetLists,
    BoardList\CreateList,
    BoardList\UpdateList,
    BoardList\DeleteList,

    Card\GetCards,
    Card\CreateCard,
    Card\UpdateCard,
    Card\DeleteCard,

    Home,
};

Route::prefix('v1')->group(function () {
    Route::get('/', Home::class);

    Route::post('/auth/signup', SignupRequest::class);
    Route::get('/auth/signup/confirm/{id}/{hash}', SignupConfirm::class)->name('verification.verify');
    Route::post('/auth/login', Login::class);

    Route::middleware(['auth:sanctum'])->group(function () {

        Route::get('/auth/logout', Logout::class);

        Route::get('/user', function (Request $request) {
            return $request->user();
        });

        Route::post('/boards', CreateBoard::class);
        Route::put('/boards/{id}', UpdateBoard::class);
        Route::get('/boards/{id}', GetBoard::class);
        Route::delete('/boards/{id}', DeleteBoard::class);

        Route::get('/lists', GetLists::class);
        Route::post('/lists', CreateList::class);
        Route::put('/lists/{id}', UpdateList::class);
        Route::get('/lists/{id}', GetList::class);
        Route::delete('/lists/{id}', DeleteList::class);

        Route::get('/cards', GetCards::class);
        Route::post('/cards', CreateCard::class);
        Route::put('/cards/{id}', UpdateCard::class);
        Route::delete('/cards/{id}', DeleteCard::class);
    });
});

