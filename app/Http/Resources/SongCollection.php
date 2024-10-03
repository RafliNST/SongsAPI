<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class SongCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {        
        return  [
            "data" => SongResource::collection($this->resource),
        ];
    }

    public function setProperties(string $message, int $statusCode) : array
    {        
        // return new SongCollection($response);
        return [
            "message" => $message,
            "status" => $statusCode,
            "data" => $this->collection
        ];
    }
}
