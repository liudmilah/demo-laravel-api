<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\Board\CreateBoard;
use App\Http\Controllers\Api\V1\Home;

Route::prefix('v1')->group(function () {
    Route::get('/', Home::class);

    Route::post('/board', CreateBoard::class);

    Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
        return $request->user();
    });
});

