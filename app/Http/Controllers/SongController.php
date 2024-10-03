<?php

namespace App\Http\Controllers;

use App\Models\Song;
use App\Models\Artist;
use Illuminate\Http\Request;
use App\Http\Resources\SongCollection;
use Illuminate\Contracts\Database\Eloquent\Builder;

class SongController extends Controller
{
    public function get(Request $request) : array 
    {
        $page = $request->input('page', 1);
        $size = $request->input('size', 5);

        $songs = Song::with(['artists', 'album']);
        $songs = $songs->where(function (Builder $builder) use ($request) {
            $title = $request->input('title');
            if ($title) {
                $builder->where('title', 'like', '%' . $title . '%');
            }
        });

        $songs = $songs->paginate(perPage: $size, page: $page);
        $songs = new SongCollection($songs);

        return $songs->setProperties("success get data", 200);
    }
}
