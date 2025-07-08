<?php

namespace App\Http\Resources\Api\Admin;
use App\Traits\HandlesImage;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ClientResource extends JsonResource
{
    use HandlesImage;
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'    => $this->id,
            'image' => $this->getImageUrl($this->image),
            'title' => $this->title,
            'des'   => $this->des,
            'alt_image' => $this->alt_image,
            'title_image' => $this->title_image,
            'created_at' => $this->created_at->format('Y-m-d '),
            'updated_at' => $this->updated_at->format('Y-m-d '),
        ];
    }
}