<?php

namespace Database\Seeders;

use App\Models\Artist;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ArtistSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Artist::create([
            'name' => 'Yorushika',
            'cover' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSInxgIfDbsNnIycYIqYSy-3rZzKNknu_GnuA&s',
            'debut' => 2017
        ]);

        Artist::create([
            'name' => 'Aimer',
            'cover' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSrFg3QOWlVu5Ofu7ijvaJrSP3J8ugFuNpOeg&s',
            'debut' => 2011
        ]);

        Artist::create([
            'name' => "Various Artist's",
            'cover' => 'https://i.scdn.co/image/ab67616d00001e0213d6a82b98d096d51a00b571',
            'debut' => 2000
        ]);

        Artist::create([
            'name' => 'Sekai no Owari',
            'cover' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRzicOMjfL1zVy70o6B_wfWVUwR18a5qNNxTA&s',
            'debut' => 2007
        ]);

        Artist::create([
            'name' => 'Hiroyuki Sawano',
            'cover' => 'https://encrypted-tbn2.gstatic.com/images?q=tbn:ANd9GcTzhtNX_d2J5l0Y6Sm8kSxGA_roXzB9Ql_xFJEFueet1QBPCoCDRJzoXkP1BnfeBYFNtw7f1hp9X60Vl3ckM8Ou5FnZa0BEpnWOrOiTeA',
            'debut' => 2004
        ]);

        Artist::create([
            'name' => 'suis from Yorushika',
            'cover' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSlXX4Le0O6QSlo4nobBnpnnBxwTxZdrBkN9Q&s',
            'debut' => 2017
        ]);
    }
}
