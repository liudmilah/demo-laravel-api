<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\{
    Auth\SignupRequest,
    Auth\SignupConfirm,

    Board\CreateBoard,

    Home,
};

Route::prefix('v1')->group(function () {
    Route::get('/', Home::class);

    Route::post('/auth/signup', SignupRequest::class);
    Route::get('/auth/signup/confirm/{id}/{hash}', SignupConfirm::class)->name('verification.verify');

    Route::post('/board', CreateBoard::class);

    Route::middleware(['auth:sanctum'])->group(function () {

        Route::get('/user', function (Request $request) {
            return $request->user();
        });

    });
});

