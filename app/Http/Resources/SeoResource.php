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
            'description' => $this->description,
            'created_at' => $this->created_at,
        ];
    }
}
