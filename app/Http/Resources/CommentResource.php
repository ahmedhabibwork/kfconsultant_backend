<?php

namespace App\Http\Resources;

use App\Models\Society;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
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
            'name' => $this->name,
            'comment' => $this->comment,
            'image' => $this->image ? url('storage/' . $this->image) : null,
            'project' => $this->project,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
        ];
    }
}
