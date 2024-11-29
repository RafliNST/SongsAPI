<?php

namespace App\Http\Controllers;

use App\Models\Artist;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\ArtistRelationship;
use App\Http\Resources\ArtistResource;
use App\Http\Resources\ArtistCollection;
use App\Http\Requests\ArtistCreateRequest;
use App\Http\Requests\ArtistUpdateRequest;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Exceptions\HttpResponseException;

class ArtistController extends Controller
{
    public function create(ArtistCreateRequest $request) : JsonResponse
    {
        $data = $request->validated();
        $artist = new Artist($data);     
        
        $artist->save();        

        return (new ArtistResource($artist))->response()->setStatusCode(201);
    }

    public function update(ArtistUpdateRequest $request, int $id) : ArtistResource
    {
        $artist = Artist::where('id', $id)->first();

        if (!$artist) {
            throw new HttpResponseException(response([
                "errors" => [
                    "message" => ['not found']
                ]
            ])->setStatusCode(404));
        }

        $data = $request->validated();
        $artist->fill($data);
        $artist->save();

        return new ArtistResource($artist);
    }

    public function get(Request $request)
    {
        $page = $request->input('page', 1);
        $size = $request->input('size', 5);

        $name = $request->input('name');

        $artists = Artist::where('name', 'like', '%' . $name . '%')->paginate(perPage: $size, page: $page);
        $artists = new ArtistCollection($artists);

        return response([
            'message' => 'success get data',
            'status' => 200,
            'data' => $artists
        ]);
    }

    public function delete(int $id)
    {
        $artist = Artist::where('id', $id)->first();

        if (!$artist) {
            throw new HttpResponseException(response([
                'errors' => [
                    'message' => ['not found']
                ]
            ])->setStatusCode(404));
        }

        $artistsRelationArtists = ArtistRelationship::where('song_id', $artist->id)->get();
        foreach($artistsRelationArtists as $artistsRelationArtist) {
            $artistsRelationArtist->delete();
        }

        $artist->delete();

        return response()->json([
            'data' => true
        ])->setStatusCode(200);
    }
}
