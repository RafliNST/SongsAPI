<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Album extends Model
{
    protected $table = "albums";
    protected $primaryKey = "id";
    protected $keyType = "int";
    public $incrementing = true;
    public $timestamps = true;
    protected $fillable = [
        'artist_id',
        'title',
        'released_date',
        'cover',
    ];

    public function artist() : BelongsTo
    {
        return $this->belongsTo(Artist::class);
    }
}
