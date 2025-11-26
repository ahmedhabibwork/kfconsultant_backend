<?php

namespace App\Http\Resources;

use App\Models\Society;
use App\Models\Tag;
use App\Models\Year;
use EightyNine\FilamentAdvancedWidget\AdvancedStatsOverviewWidget\Stat;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
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

            'id'              => $this->id,
            'title'           => $this->title,
            'slug'            => $this->slug,
            'short_description'     => $this->short_description,
            'description'     => $this->description,
            'category' => new CategoryResource ($this->category),
            'scope' => new ScopeResource($this->scope),
            'scale' => new ScaleResource($this->scale),
            'status' =>new StatusResource($this->status),
            'year' => new YearResource($this->year),
            'owner'        => $this->owner,
            'location'      => $this->location,
            'map_link'        => $this->map_link,
            'cover_image' => $this->cover_image ? url('storage/' . $this->cover_image) : null,
            'images' => $this->images ? array_map(function ($image) {
                return url('storage/' . $image);
            }, $this->images) : [],
            'meta_title'      => $this->meta_title,
            'meta_description' => $this->meta_description,
            'created_at'      => $this->created_at?->format('Y-m-d H:i:s'),

        ];
    }
}
