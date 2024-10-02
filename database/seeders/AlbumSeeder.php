<?php

namespace Database\Seeders;

use App\Models\Album;
use App\Models\Artist;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AlbumSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call([ArtistSeeder::class]);
        $artist = Artist::query()->get();

        Album::create([
            'artist_id' => $artist[0]->id,
            'title' => "A Loser Doesn't Need an Encore",
            'released_date' => '2018-05-08',
            'cover' => 'https://upload.wikimedia.org/wikipedia/en/4/4e/Yorushika_-_A_Loser_Doesn%27t_Need_an_Encore.png'
        ]);

        Album::create([
            'artist_id' => $artist[0]->id,
            'title' => "Magic Lantern",
            'released_date' => '2023-04-05',
            'cover' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcR9S4gMOttEN2ESO8_JTYpXA0ypcf8wrl4AUw&s'
        ]);

        Album::create([
            'artist_id' => $artist[2]->id,
            'title' => "もしも生まれ変わったならそっとこんな声になって",
            'released_date' => '2024-08-28',
            'cover' => 'https://is1-ssl.mzstatic.com/image/thumb/Music221/v4/10/23/a7/1023a79c-dc39-dd88-2d4e-6e259455b76f/24UMGIM90423.rgb.jpg/1200x1200bf-60.jpg'
        ]);

        Album::create([
            'artist_id' => $artist[4]->id,
            'title' => "V",
            'released_date' => '2023-01-18',
            'cover' => 'https://upload.wikimedia.org/wikipedia/en/thumb/2/21/Cover_art_for_%22V%22%2C_album_by_Hiroyuki_Sawano.jpg/220px-Cover_art_for_%22V%22%2C_album_by_Hiroyuki_Sawano.jpg'
        ]);
    }
}
