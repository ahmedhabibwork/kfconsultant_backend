<?php

namespace App\Http\Resources;

use App\Models\Society;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
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
            'description' => $this->description,
            'image' => $this->image ? url(path: 'storage/' . $this->image) : null,
            'subCategories' => SubCategoryResource::collection($this->subCategories),
            'trips' => TripResource::collection($this->trips),
            'hasTrips' => $this->hasTrips(),
            'created_at' => $this->created_at,
        ];
    }
}
