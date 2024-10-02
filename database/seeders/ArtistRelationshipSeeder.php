<?php

namespace Database\Seeders;

use App\Models\Song;
use App\Models\Artist;
use Illuminate\Database\Seeder;
use App\Models\ArtistRelationship;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ArtistRelationshipSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call([SongSeeder::class]);

        $songs = Song::all();
        $artists = Artist::all();

        ArtistRelationship::create([
            'song_id' => $songs[0]->id,
            'artist_id' => $artists[0]->id
        ]);

        ArtistRelationship::create([
            'song_id' => $songs[1]->id,
            'artist_id' => $artists[3]->id
        ]);

        ArtistRelationship::create([
            'song_id' => $songs[2]->id,
            'artist_id' => $artists[4]->id
        ]);

        ArtistRelationship::create([
            'song_id' => $songs[2]->id,
            'artist_id' => $artists[5]->id
        ]);
    }
}
