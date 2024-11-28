<?php

namespace Tests\Feature;

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
            'Authorization' => 'token'
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
                // $artist->id+2
            ]
        ], [
            'Authorization' => 'token'
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
}
