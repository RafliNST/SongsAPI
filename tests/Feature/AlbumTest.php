<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Album;
use App\Models\Artist;
use Database\Seeders\UserSeeder;
use Database\Seeders\AlbumSeeder;
use Database\Seeders\ArtistSeeder;
use Illuminate\Foundation\Testing\WithFaker;
use Database\Seeders\ArtistRelationshipSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AlbumTest extends TestCase
{
    public function testCreateSuccess()
    {
        $this->seed([UserSeeder::class, ArtistSeeder::class]);
        $artist = Artist::query()->limit(1)->first();

        $this->post('/api/albums', [
            'title' => 'Plagiarism',
            'artist_id' => $artist->id,
            'cover' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT-i6eQR1FtJ667uhb1JMwCXjyp5tds2ebJKg&s',
            'released_date' => '2020-07-29',
        ], [
            'Authorization' => 'token'
        ])->assertStatus(201)
            ->assertJson([
                'data' => [
                    'cover' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT-i6eQR1FtJ667uhb1JMwCXjyp5tds2ebJKg&s',
                    'released_date' => '2020-07-29',
                    'title' => 'Plagiarism'
                ]
            ]);
    }

    public function testCreateArtistNotFound()
    {
        $this->seed([UserSeeder::class, ArtistSeeder::class]);
        $artist = Artist::query()->limit(1)->first();

        $this->post('/api/albums', [
            'title' => 'Plagiarism',
            'artist_id' => $artist->id + 10,
            'cover' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT-i6eQR1FtJ667uhb1JMwCXjyp5tds2ebJKg&s',
            'released_date' => '2020-07-29',
        ], [
            'Authorization' => 'token'
        ])->assertStatus(404)
            ->assertJson([
                'errors' => [
                    'message' => ['not found'],
                ]
            ]);
    }

    public function testCreateFailed()
    {
        $this->seed([UserSeeder::class, ArtistSeeder::class]);
        $artist = Artist::query()->limit(1)->first();

        $this->post('/api/albums', [
            'title' => 'Plagiarism',
            'artist_id' => $artist->id,
            'cover' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT-i6eQR1FtJ667uhb1JMwCXjyp5tds2ebJKg&s',
            'released_date' => 'tahun-segini',
        ], [
            'Authorization' => 'token'
        ])->assertStatus(400)
            ->assertJson([
                'errors' => [
                    'released_date' => [
                        'The released date field must be a valid date.',
                        'The released date field must match the format Y-m-d.',
                    ],
                ]
            ]);
    }

    public function testUpdateSuccess()
    {
        $this->seed([UserSeeder::class, ArtistRelationshipSeeder::class]);
        
        $album = Album::query()->limit(1)->first();
        $artist = Artist::query()->limit(1)->first();

        $this->put('/api/albums/' . $album->id, [
            'artist_id' => $artist->id,
            'title' => "負け犬にアンコールはいらない",
            'released_date' => '2018-05-08',
            'cover' => 'https://upload.wikimedia.org/wikipedia/en/4/4e/Yorushika_-_A_Loser_Doesn%27t_Need_an_Encore.png'
        ], [
            'Authorization' => 'token'
        ])->assertStatus(200)
            ->assertJson([
                'data' => [                    
                    'id' => $album->id,
                    'title' => '負け犬にアンコールはいらない',
                    'released_date' => '2018-05-08',
                    'cover' => 'https://upload.wikimedia.org/wikipedia/en/4/4e/Yorushika_-_A_Loser_Doesn%27t_Need_an_Encore.png',
                    'artist' => [                    
                        'id' => $artist->id,
                        'name' => $artist->name,
                        'cover' => $artist->cover,
                        'debut' => $artist->debut,
                    ]
                ]
            ]);
    }

    public function testUpdateAlbumNotFound()
    {
        $this->seed([UserSeeder::class, ArtistRelationshipSeeder::class]);
        
        $album = Album::query()->limit(1)->first();
        $artist = Artist::query()->limit(1)->first();

        $this->put('/api/albums/' . $album->id + 10, [
            'artist_id' => $artist->id,
            'title' => "負け犬にアンコールはいらない",
            'released_date' => '2018-05-08',
            'cover' => 'https://upload.wikimedia.org/wikipedia/en/4/4e/Yorushika_-_A_Loser_Doesn%27t_Need_an_Encore.png'
        ], [
            'Authorization' => 'token'
        ])->assertStatus(404)
            ->assertJson([
                'errors' => [                    
                    'message' => ['not found'],
                ]
            ]);
    }

    public function testUpdateArtistNotFound()
    {
        $this->seed([UserSeeder::class, ArtistRelationshipSeeder::class]);
        
        $album = Album::query()->limit(1)->first();
        $artist = Artist::query()->limit(1)->first();

        $this->put('/api/albums/' . $album->id, [
            'artist_id' => $artist->id + 10,
            'title' => "負け犬にアンコールはいらない",
            'released_date' => '2018-05-08',
            'cover' => 'https://upload.wikimedia.org/wikipedia/en/4/4e/Yorushika_-_A_Loser_Doesn%27t_Need_an_Encore.png'
        ], [
            'Authorization' => 'token'
        ])->assertStatus(404)
            ->assertJson([
                'errors' => [                    
                    'message' => ['artist not found'],
                ]
            ]);
    }

    public function testDeleteSuccess()
    {
        $this->seed([UserSeeder::class, AlbumSeeder::class]);

        $album = Album::query()->limit(1)->first();

        $this->delete('/api/albums/' . $album->id, [

        ], [
            'Authorization' => 'token'
        ])->assertStatus(200)
            ->assertJson([
                'data' => true
            ]);
    }

    public function testDeleteNotFound()
    {
        $this->seed([UserSeeder::class, AlbumSeeder::class]);

        $album = Album::query()->limit(1)->first();

        $this->delete('/api/albums/' . $album->id + 10, [

        ], [
            'Authorization' => 'token'
        ])->assertStatus(404)
            ->assertJson([
                'errors' => [
                    'message' => ['not found']
                ]
            ]);
    }
}
