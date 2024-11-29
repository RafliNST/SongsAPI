<?php

namespace App\Http\Controllers;

use App\Models\Song;
use App\Models\Album;
use App\Models\Artist;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\ArtistRelationship;
use App\Http\Resources\SongResource;
use App\Http\Resources\SongCollection;
use App\Http\Requests\SongCreateRequest;
use App\Http\Requests\SongUpdateRequest;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Exceptions\HttpResponseException;

class SongController extends Controller
{
    public function create(SongCreateRequest $request) : JsonResponse
    {
        $data = $request->validated();
        $song = new Song($data);

        $artistsId = $request->artists;

        $artists = Artist::whereIn('id', $artistsId)->get();

        if ($artists->isEmpty()) {
            throw new HttpResponseException(response([
                'errors' => [
                    'message' => ['not found']
                ]
            ])->setStatusCode(404));
        }

        $albumId = $request->album_id;
        $album = Album::where('id', $albumId)->first();

        if (!$album && $albumId != null) {
            throw new HttpResponseException(response([
                'errors' => [
                    'message' => ['not found']
                ]
            ])->setStatusCode(404));
        }
        
        $song->save();

        if ($song && $artists) {
            $artists = $request->artists;

            foreach($artists as $artist) {
                $createRelation = new ArtistRelationship();
                $createRelation->song_id = $song->id;
                $createRelation->artist_id = $artist;
                $createRelation->save();
            }
        }

        return (new SongResource($song))->response()->setStatusCode(201);
    }

    public function update(SongUpdateRequest $request, int $id) : SongResource
    {
        $song = Song::where('id', $id)->first();

        if (!$song) {
            throw new HttpResponseException(response([
                "errors" => [
                    "message" => ['not found']
                ]
            ])->setStatusCode(404));
        }

        $data = $request->validated();

        $artistsId = $request->artists;

        $artists = Artist::whereIn('id', $artistsId)->get();

        if ($artists->isEmpty()) {
            throw new HttpResponseException(response([
                'errors' => [
                    'message' => ['not found']
                ]
            ])->setStatusCode(404));
        }
        
        $song->fill($data);
        $song->save();

        if ($song && $artists) {
            $artists = $request->artists;

            $oldArtistRelationships = ArtistRelationship::where('song_id', $song->id)->get();
            foreach($oldArtistRelationships as $oldArtistRelationship) {
                $oldArtistRelationship->delete();
            }

            foreach($artists as $artist) {
                $createRelation = new ArtistRelationship();
                $createRelation->song_id = $song->id;
                $createRelation->artist_id = $artist;
                $createRelation->save();
            }
        }    

        return new SongResource($song);
    }

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

    public function delete(int $id) : JsonResponse 
    {
        $song = Song::where('id', $id)->first();        

        if (!$song) {
            throw new HttpResponseException(response([
                'errors' => [
                    'message' => ['not found']
                ]
            ])->setStatusCode(404));
        }

        $songRelationArtists = ArtistRelationship::where('song_id', $song->id)->get();
        foreach($songRelationArtists as $songRelationArtist) {
            $songRelationArtist->delete();
        }

        $song->delete();

        return response()->json([
            'data' => true
        ])->setStatusCode(200);
    }
}