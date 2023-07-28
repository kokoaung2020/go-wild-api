<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Resources\Json\JsonResource;

class FeaturedToursResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "title" => $this->title,
            "address" => $this->address,
            "price" => $this->price,
            "promotion" => $this->promotion,
            "photo" => asset(Storage::url($this->photo)),
            "date" => $this->created_at->format("d M Y"),
            "time" => $this->created_at->format("H:i")
        ];
    }
}
