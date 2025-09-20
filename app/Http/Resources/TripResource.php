<?php

namespace App\Http\Resources;

use App\Models\Society;
use Illuminate\Http\Resources\Json\JsonResource;

class TripResource extends JsonResource
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
            // 'category' => [
            //     'id' => $this->category?->id,
            //     'slug' => $this->category?->slug,
            //     'title' => $this->category?->title,
            // ],
            // 'sub_category' => [
            //     'id' => $this->subCategory?->id,
            //     'slug' => $this->subCategory?->slug,
            //     'title' => $this->subCategory?->title,
            // ],

            // 'destination'     => $this->destination,
            'overview'        => $this->overview,
            'highlights'      => $this->highlights,
            'itinerary'       => $this->itinerary,
            'accommodation'   => $this->accommodation,
            'inclusions'      => $this->inclusions,

            'duration'        => $this->duration,
            'price'           => $this->price,
            'currency'        => $this->currency,
            'cover_image' => $this->cover_image ? url('storage/' . $this->cover_image) : null,
            'images' => $this->images ? array_map(function ($image) {
                return url('storage/' . $image);
            }, $this->images) : [],
            'description'     => $this->description,
            'map_link'        => $this->map_link,
            'rating'          => $this->rating,
            'is_popular'      => $this->is_popular,
            'is_best_seller'     => $this->is_best_seller,
            'meta_title'      => $this->meta_title,
            'meta_description' => $this->meta_description,
            'created_at'      => $this->created_at?->format('Y-m-d H:i:s'),

        ];
    }
}
