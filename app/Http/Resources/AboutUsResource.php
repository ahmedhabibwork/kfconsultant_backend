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
            'mission' => $this->mission,
            'vision' => $this->vision,
            'our_founder' => $this->our_founder,
            'mission_image' => $this->mission ? url('storage/' . $this->mission) : null,
            'vision_image' => $this->vision ? url('storage/' . $this->vision) : null,
            'our_founder_image' => $this->our_founder ? url('storage/' . $this->our_founder) : null,
            'phone' => $this->phone,
            'experience_years' => $this->experience_years,
            'image' => $this->image ? url('storage/' . $this->image) : null,
            'created_at' => $this->created_at,
        ];
    }
}
