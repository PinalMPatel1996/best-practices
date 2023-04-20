<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
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
            'body' => $this->body,
            'file_url' => $this->file_url,
            'visibility' => $this->visibility,
            'is_published' => $this->is_published,
            'user' => UserResource::make($this->whenLoaded('user')),
        ];
    }
}
