<?php

namespace App\Http\Resources;

use App\Models\Society;
use Illuminate\Http\Resources\Json\JsonResource;

class AboutUsResource extends JsonResource
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
            'title' => $this->title,
            'short_description' => $this->short_description,
            'description' => $this->description,
            'experience_years' => $this->experience_years,
            'image' => $this->image ? url('storage/' . $this->image) : null,
            'created_at' => $this->created_at,
        ];
    }
}
