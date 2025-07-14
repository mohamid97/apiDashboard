<?php

namespace App\Http\Resources\Api\Admin;

use App\Traits\HandlesImage;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OurworkResource extends JsonResource
{
    use HandlesImage;
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $images = [];
        if($this->images){
            foreach ($this->images as $image) {
                $images[] = $this->getImageUrl($image);
            }  

        }

        return [
            'id' => $this->id,
            'images' => $this->images,
            'link' => $this->link,
            'breadcrumb' => $this->getImageUrl($this->breadcrumb),
            'title' => $this->title,
            'des' => $this->des,
            'meta_title' => $this->meta_title,
            'meta_des' => $this->meta_des,
            'created_at' => $this->created_at ? $this->created_at->format('Y-m-d') : null,
            'updated_at' => $this->updated_at ? $this->updated_at->format('Y-m-d') : null,
        ];
    }
}