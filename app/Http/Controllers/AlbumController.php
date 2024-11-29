<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\Artist;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use App\Http\Resources\AlbumResource;
use App\Http\Resources\AlbumCollection;
use App\Http\Requests\AlbumCreateRequest;
use App\Http\Requests\AlbumUpdateRequest;

class AlbumController extends Controller
{
    public function get(Request $request)
    {
        $page = $request->input('page', 1);
        $size = $request->input('size', 5);

        $title = $request->input('title');

        $albums = Album::where('title', 'like', '%' . $title . '%')->paginate(perPage: $size, page: $page);
        $albums = new AlbumCollection($albums);
        
        return response([
            'message' => 'success get data',
            'status' => 200,
            'data' => $albums
        ]);
    }

    public function create(AlbumCreateRequest $request)
    {        
        $data = $request->validated();

        $artist = Artist::where('id', $data['artist_id'])->first();
        if(!$artist) {
            throw new HttpResponseException(response([
                'errors' => [
                    'message' => ['not found']
                ]
            ])->setStatusCode(404));
        }

        $album = new Album($data);
        $album->save();

        return (new AlbumResource($album))->response()->setStatusCode(201);
    }

    public function update(AlbumUpdateRequest $request, int $id)
    {
        $album = Album::where('id', $id)->first();

        if (!$album) {
            throw new HttpResponseException(response([
                'errors' => [
                    'message' => ['not found']
                ]
            ])->setStatusCode(404));
        }

        $data = $request->validated();
        $album->fill($data);
        $album->save();

        return new AlbumResource($album);
    }

    public function delete(int $id)
    {
        $album = Album::where('id', $id)->first();
        
        if (!$album) {
            throw new HttpResponseException(response([
                'errors' => [
                    'message' => ['not found']
                ]
            ])->setStatusCode(404));
        }

        $album->delete();

        return response([
            'data' => true
        ])->setStatusCode(200);
    }
}
