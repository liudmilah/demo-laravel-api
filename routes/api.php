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

        Route::post('/board', CreateBoard::class);
        Route::put('/board/{id}', UpdateBoard::class);
        Route::get('/board/{id}', GetBoard::class);
        Route::delete('/board/{id}', DeleteBoard::class);
    });
});

