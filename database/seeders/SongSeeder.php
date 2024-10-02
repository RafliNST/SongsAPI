<?php

namespace Database\Seeders;

use App\Models\Song;
use App\Models\Album;
use App\Models\Artist;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SongSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call([AlbumSeeder::class]);

        $album = Album::query()->get();
        
        Song::create([
            // 'artist_id' => $artist[0]->id,
            'title' => '憂、燦々',
            'released_date' => '2024-08-28',
            'album_id' => $album[2]->id
        ]);

        Song::create([
            // 'artist_id' => $artist[3]->id,
            'title' => '栞',
            'released_date' => '2024-08-28',
            'album_id' => $album[2]->id
        ]);

        Song::create([
            // 'artist_id' => $artist[3]->id,
            'title' => 'B∀LK',
            'released_date' => '2023-01-18',
            'album_id' => $album[3]->id
        ]);
    }
}
