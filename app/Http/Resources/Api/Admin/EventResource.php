<?php

namespace App\Http\Resources\Api\Admin;
use App\Traits\HandlesImage;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EventResource extends JsonResource
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
        foreach ($this->images as $image) {
            $images[] = $this->getImageUrl($image);
        }  
        return [
            'id' => $this->id,
            'title' => $this->title,
            'des' => $this->des,
            'images' => $images,
            'breadcrumb' => $this->getImageUrl($this->breadcrumb),
            'date' => $this->date ? $this->date->format('Y-m-d') : null,
            'meta_title' => $this->meta_title,
            'meta_des' => $this->meta_des,
            'alt_image' => $this->alt_image,
            'title_image' => $this->title_image,
            'created_at' => $this->created_at->format('Y-m-d'),
            'updated_at' => $this->updated_at->format('Y-m-d'),
        ];
    }



}