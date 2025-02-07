<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'username' => 'RANst',
            'password' => Hash::make('rahasia'),
            'name' => 'Rafli A.N',
            'role' => 'listener',
            'token' => 'token'
        ]);

        User::create([
            'username' => 'admin',
            'password' => Hash::make('admin'),
            'name' => 'admin',
            'role' => 'admin',
            'token' => 'admin'
        ]);        
    }
}
