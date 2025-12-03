<?php

namespace App\Http\Resources\HomePage;

use App\Filament\Resources\CategoryResource;
use App\Filament\Resources\ScopeResource;
use App\Http\Resources\CategoryResource as ResourcesCategoryResource;
use App\Http\Resources\ScaleResource;
use App\Http\Resources\ScopeResource as ResourcesScopeResource;
use App\Http\Resources\StatusResource;
use App\Http\Resources\YearResource;
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
            'location'      => $this->location,
            // 'description'     => $this->description,
            'category' => new ResourcesCategoryResource($this->category),
            // 'scope' => new ResourcesScopeResource($this->scope),
            // 'scale' => new ScaleResource($this->scale),
            // 'status' => new StatusResource($this->status),
            // 'year' => new YearResource($this->year),
            // 'owner'        => $this->owner,
            'cover_image' => $this->cover_image ? url('storage/' . $this->cover_image) : null,
            'meta_title'      => $this->meta_title,
            'meta_description' => $this->meta_description,
        ];
    }
}
