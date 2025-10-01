<?php

namespace App\Http\Resources;

use App\Models\Society;
use Illuminate\Http\Resources\Json\JsonResource;

class SeoResource extends JsonResource
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
            'page_name' => $this->page_name,
            'title' => $this->title,
            'og_description' => $this->og_description,
            'og_image' => $this->og_image ? url('storage/' . $this->og_image) : null,
            'twitter_description' => $this->twitter_description,
            'twitter_image' => $this->twitter_image ? url('storage/' . $this->twitter_image) : null,
            'description' => $this->description,
            'created_at' => $this->created_at,
        ];
    }
}
