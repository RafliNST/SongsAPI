<?php

namespace App\Models;

use App\Models\Artist;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Song extends Model
{
    protected $table = "songs";
    protected $primaryKey = "id";
    protected $keyType = "int";
    public $incrementing = true;
    public $timestamps = true;
    protected $fillable = [
        'title',
        'released_date',
        'cover',
        'album_id'
    ];

    public function album() : BelongsTo
    {
        return $this->belongsTo(Album::class);
    }

    public function artists() : HasManyThrough
    {
        return $this->hasManyThrough(
            Artist::class,
            ArtistRelationship::class,
            'song_id',
            'id',
            'id',
            'artist_id'
        );
    }
}
