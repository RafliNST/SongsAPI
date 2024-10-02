<?php

use App\Models\Song;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response()->json([
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
        'message' => 'test awal saja',
        'status' => 200
    ]);
});

Route::get('/songs', function() {
    return response()->json([
        'data' => [
            Song::with(['artists', 'album'])->get()
        ]
    ])->setStatusCode(200);
});

Route::get('/hooh', function() {
    return "asddfas";
});
