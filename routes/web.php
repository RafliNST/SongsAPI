<?php

use App\Models\Album;
use App\Models\Artist;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SongController;

Route::get('/', function () 
{
    return response()->json([
        'message' => 'test awal saja',
        'status' => 200,
        'data' => Album::where('title', 'V')->get()
    ]);
});

Route::get('/songs', function() {
    return view('form-create-song', [
        'albums' => Album::all(),
        'artists' => Artist::all()
    ]);
});
