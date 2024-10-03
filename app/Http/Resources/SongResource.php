<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SongResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'released_date' => $this->released_date,
            'cover' => $this->cover,
            'album' => new AlbumResource($this->album),
            // 'artist' => $this->artists,
            'artists' => ArtistResource::collection($this->artists)
        ];
    }
}
