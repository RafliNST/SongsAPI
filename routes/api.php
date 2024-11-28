<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SongController;
use App\Http\Middleware\ApiAuthMiddleware;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware(ApiAuthMiddleware::class)->group(function() {
    Route::post('/songs', [SongController::class, 'create']);
    Route::put('/songs/{id}', [SongController::class, 'update']);
});

Route::get('/songs', [SongController::class, 'get']);