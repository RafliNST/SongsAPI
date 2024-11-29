<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Artist;
use Database\Seeders\UserSeeder;
use Database\Seeders\ArtistSeeder;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ArtistTest extends TestCase
{
    public function testCreateSuccess()
    {
        $this->seed([UserSeeder::class]);
        $this->post('/api/artists', [
            'name' => 'Omoinotake',
            'cover' => 'https://yt3.googleusercontent.com/CqtM5BDhL1KAz1AaxBXwEIVA6AaBPjcKnspYbYAiLfnG1kFvKmeXU5EByay2NWtsYoDWLpbstF4=s900-c-k-c0x00ffffff-no-rj',
            'debut' => '2012'
        ], [
            'Authorization' => 'token'
        ])->assertStatus(201)
            ->assertJson([
                'data' => [
                    'name' => 'Omoinotake',
                    'cover' => 'https://yt3.googleusercontent.com/CqtM5BDhL1KAz1AaxBXwEIVA6AaBPjcKnspYbYAiLfnG1kFvKmeXU5EByay2NWtsYoDWLpbstF4=s900-c-k-c0x00ffffff-no-rj',
                    'debut' => '2012'
                ]
            ]);
    }

    public function testUpdateSuccess()
    {
        $this->seed([UserSeeder::class, ArtistSeeder::class]);
        $artist = Artist::query()->limit(1)->first();

        $this->put('/api/artists/' . $artist->id, [
            'name' => 'ヨルシカ',
            'debut' => '2017',
            'cover' => 'https://upload.wikimedia.org/wikipedia/commons/2/27/Yorushika_Logo.jpg'
        ], [
            'Authorization' => 'token'
        ])->assertStatus(200)
            ->assertJson([
                'data' => [
                    'name' => 'ヨルシカ',
                    'debut' => '2017',
                    'cover' => 'https://upload.wikimedia.org/wikipedia/commons/2/27/Yorushika_Logo.jpg'
                ]
            ]);
    }

    public function testDeleteSuccess()
    {
        $this->seed([UserSeeder::class, ArtistSeeder::class]);
        $artist = Artist::query()->limit(1)->first();

        $this->delete('/api/artists/' . $artist->id, [

        ], [
            'Authorization' => 'token'
        ])->assertStatus(200)
            ->assertJson([
                'data' => true
            ]);
    }
}
