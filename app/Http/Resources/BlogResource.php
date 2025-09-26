<?php

namespace App\Http\Resources;

use App\Models\Society;
use Illuminate\Http\Resources\Json\JsonResource;

class BlogResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'slug' => $this->slug,
            'title' => $this->title,
            // 'category' => $this->category?->title,
            'short_description' => $this->short_description,
            'description' => $this->description,
            'meta_title' => $this->meta_title,
            'meta_description' => $this->meta_description,
            'images' => $this->images ? array_map(function ($image) {
                return url('storage/' . $image);
            }, $this->images) : [],
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
        ];
    }
}
