<?php

use App\Http\Controllers\AlbumController;
use App\Http\Controllers\ArtistController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SongController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\ApiAuthMiddleware;
use App\Http\Middleware\CheckRoleMiddleware;

Route::post('/users', [UserController::class, 'register']);
Route::post('/users/login', [UserController::class, 'login']);

Route::middleware(ApiAuthMiddleware::class)->group(function() {
    Route::middleware(CheckRoleMiddleware::class)->group(function() {
        Route::post('/songs', [SongController::class, 'create']);
        Route::put('/songs/{id}', [SongController::class, 'update']);
        Route::delete('/songs/{id}', [SongController::class, 'delete']);
    
        Route::post('/artists', [ArtistController::class, 'create']);
        Route::put('/artists/{id}', [ArtistController::class, 'update']);
        Route::delete('/artists/{id}', [ArtistController::class, 'delete']);
    
        Route::post('/albums', [AlbumController::class, 'create']);
        Route::put('/albums/{id}', [AlbumController::class, 'update']);
        Route::delete('/albums/{id}', [AlbumController::class, 'delete']);
    });

    Route::get('/users/current', [UserController::class, 'get']);
    Route::patch('/users/current', [UserController::class, 'update']);
    Route::delete('/users/logout', [UserController::class, 'logout']);
});

Route::get('/songs', [SongController::class, 'get']);
Route::get('/artists', [ArtistController::class, 'get']);
Route::get('/albums', [AlbumController::class, 'get']);