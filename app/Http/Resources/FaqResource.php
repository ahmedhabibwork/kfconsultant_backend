<?php

namespace App\Http\Resources;

use App\Models\Society;
use Illuminate\Http\Resources\Json\JsonResource;

class FaqResource extends JsonResource
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
            'question' => $this->question,
            'answer' => $this->answer,
            // 'image' => $this->image ? url(path: 'storage/' . $this->image) : null,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
        ];
    }
}
