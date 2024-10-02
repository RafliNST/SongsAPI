<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('artist_relationships', function (Blueprint $table) {
            $table->id();
            $table->foreignId('artist_id')->constrained('artists', 'id', 'relastion_artist');
            $table->foreignId('song_id')->constrained('songs', 'id', 'relation_songs');
            $table->timestamps();
        });
    }
    
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('artist_relationships');
    }
};
