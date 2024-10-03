<?php

use App\Http\Controllers\SongController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () 
{
    return response()->json([
        'message' => 'test awal saja',
        'status' => 200,
        'data' => [
            [
                'id' => 1,
                'name' => 'Yorushika'
            ],
            [
                'id' => 2,
                'name' => 'Aimer'
            ],
            [
                'id' => 3,
                'name' => 'One Ok Rock'
            ],
        ],        
    ]);
});

Route::get('/song', [SongController::class, 'get']);
