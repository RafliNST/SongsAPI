<?php

namespace Tests\Feature;

use App\Http\Resources\ArtistCollection;
use Tests\TestCase;
use App\Models\Song;
use App\Models\Album;
use App\Models\Artist;
use Database\Seeders\UserSeeder;
use Database\Seeders\ArtistRelationshipSeeder;

class SongTest extends TestCase
{
    public function testCreateSuccess()
    {
        $this->seed([UserSeeder::class, ArtistRelationshipSeeder::class]);
        $album = Album::query()->limit(1)->first();
        $artists = Artist::query()->limit(1)->first();

        $this->post('/api/songs', [
            'title' => 'ただ君に晴れ',
            'released_date' => '2018-05-05',
            'album_id' => $album->id,
            'artists' => [
                $artists->id
            ]
        ], [
            'Authorization' => 'admin'
        ])->assertStatus(201)
            ->assertJson([
                'data' => [
                    'title' => 'ただ君に晴れ',
                    'released_date' => '2018-05-05',
                    'album' => [
                        'id' => $album->id,
                        'title' => $album->title,
                        'released_date' => $album->released_date,
                        'cover' => $album->cover
                    ],
                    'artists' => [
                        [
                            'id' => $artists->id,
                            'name' => $artists->name,
                            'cover' => $artists->cover,
                            'debut' => $artists->debut
                        ]
                    ]
                ]
            ]);
    }

    public function testNotAllowed()
    {
        $this->seed([UserSeeder::class, ArtistRelationshipSeeder::class]);
        $album = Album::query()->limit(1)->first();
        $artists = Artist::query()->limit(1)->first();

        $this->post('/api/songs', [
            'title' => 'ただ君に晴れ',
            'released_date' => '2018-05-05',
            'album_id' => $album->id,
            'artists' => [
                $artists->id
            ]
        ], [
            'Authorization' => 'token'
        ])->assertStatus(401)
            ->assertJson([
                'errors' => [
                    'message' => ['not allowed'],                    
                ]
            ]);
    }

    public function testCreateArtistNotFound()
    {
        $this->seed([UserSeeder::class, ArtistRelationshipSeeder::class]);
        $album = Album::query()->limit(1)->first();
        $artists = Artist::query()->limit(1)->first();

        $this->post('/api/songs', [
            'title' => 'ただ君に晴れ',
            'released_date' => '2018-05-05',
            'album_id' => $album->id,
            'artists' => [
                $artists->id + 10
            ]
        ], [
            'Authorization' => 'admin'
        ])->assertStatus(404)
            ->assertJson([
                'errors' => [
                    'message' => ['artist(s) not found'],                    
                ]
            ]);
    }

    public function testCreateAlbumNotFound()
    {
        $this->seed([UserSeeder::class, ArtistRelationshipSeeder::class]);
        $album = Album::query()->limit(1)->first();
        $artists = Artist::query()->limit(1)->first();

        $this->post('/api/songs', [
            'title' => 'ただ君に晴れ',
            'released_date' => '2018-05-05',
            'album_id' => $album->id + 10,
            'artists' => [
                $artists->id
            ]
        ], [
            'Authorization' => 'admin'
        ])->assertStatus(404)
            ->assertJson([
                'errors' => [
                    'message' => ['album not found'],                    
                ]
            ]);
    }

    public function testCreateNullAlbumSuccess()
    {
        $this->seed([UserSeeder::class, ArtistRelationshipSeeder::class]);
        $album = Album::query()->limit(1)->first();
        $artists = Artist::query()->limit(1)->first();

        $this->post('/api/songs', [
            'title' => 'ただ君に晴れ',
            'released_date' => '2018-05-05',
            // 'album_id' => $album->id + 10,
            'artists' => [
                $artists->id
            ]
        ], [
            'Authorization' => 'admin'
        ])->assertStatus(201)
            ->assertJson([
                'data' => [
                    'title' => 'ただ君に晴れ',
                    'released_date' => '2018-05-05',
                    'cover' => null,
                    'album' => null,
                    'artists' => [
                        [
                            'id' => $artists->id,
                            'name' => $artists->name,
                            'cover' => $artists->cover,
                            'debut' => $artists->debut
                        ]
                    ]
                ]
            ]);
    }

    public function testUpdateSuccess()
    {
        $this->seed([UserSeeder::class, ArtistRelationshipSeeder::class]);
        $song = Song::query()->limit(1)->first();
        $artist = Artist::query()->limit(1)->first();
        $album = Album::where('id', $song->album_id+1)->first();

        $this->put('/api/songs/' . $song->id, [
            'title' => '爆弾魔',
            'released_date' => '2018-05-05',
            'album_id' => $album->id,
            'artists' => [
                $artist->id,
            ]
        ], [
            'Authorization' => 'admin'
        ])->assertStatus(200)
            ->assertJson([
                'data' => [
                    'title' => '爆弾魔',
                    'released_date' => '2018-05-05',
                    'album' => [
                        'id' => $album->id,
                        'title' => $album->title,
                        'released_date' => $album->released_date,
                        'cover' => $album->cover
                    ],
                    'artists' => [
                        [
                            'id' => $artist->id,
                            'name' => $artist->name,
                            'cover' => $artist->cover,
                            'debut' => $artist->debut
                        ],
                    ]
                ]
            ]);
    }

    public function testUpdateArtistNotFound()
    {
        $this->seed([UserSeeder::class, ArtistRelationshipSeeder::class]);
        $song = Song::query()->limit(1)->first();
        $artist = Artist::query()->limit(1)->first();
        $album = Album::where('id', $song->album_id+1)->first();

        $this->put('/api/songs/' . $song->id, [
            'title' => '爆弾魔',
            'released_date' => '2018-05-05',
            'album_id' => $album->id,
            'artists' => [
                $artist->id + 10,
            ]
        ], [
            'Authorization' => 'admin'
        ])->assertStatus(404)
            ->assertJson([
                'errors' => [
                    'message' => ['artist(s) not found'],                  
                ]
            ]);
    }

    public function testUpdateAlbumNotFound()
    {
        $this->seed([UserSeeder::class, ArtistRelationshipSeeder::class]);
        $song = Song::query()->limit(1)->first();
        $artist = Artist::query()->limit(1)->first();
        $album = Album::where('id', $song->album_id+1)->first();

        $this->put('/api/songs/' . $song->id, [
            'title' => '爆弾魔',
            'released_date' => '2018-05-05',
            'album_id' => $album->id + 10,
            'artists' => [
                $artist->id,
            ]
        ], [
            'Authorization' => 'admin'
        ])->assertStatus(404)
            ->assertJson([
                'errors' => [
                    'message' => ['album not found'],                  
                ]
            ]);
    }

    public function testDeleteSuccess()
    {
        $this->seed([UserSeeder::class, ArtistRelationshipSeeder::class]);
        $song = Song::query()->limit(1)->first();

        $this->delete('/api/songs/' . $song->id, [

        ], [
            'Authorization' => 'admin'
        ])->assertStatus(200)
            ->assertJson([
                'data' => [
                    'success'
                ]
            ]);
    }

    public function testDeleteNotFound()
    {
        $this->seed([UserSeeder::class, ArtistRelationshipSeeder::class]);
        $song = Song::query()->limit(1)->first();

        $this->delete('/api/songs/' . $song->id + 10, [

        ], [
            'Authorization' => 'admin'
        ])->assertStatus(404)
            ->assertJson([
                'errors' => [
                    'message' => ['not found']
                ]
            ]);
    }
}
