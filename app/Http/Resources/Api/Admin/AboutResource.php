<?php

namespace App\Http\Resources\Api\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Traits\HandlesImage;
class AboutResource extends JsonResource
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
            'title'=>$this->title,
            'des'=>$this->des,
            'image'=>$this->getImageUrl($this->image),
            'title_image'=>$this->title_image,
            'alt_image'=>$this->alt_image,
            'breadcrumb'=>$this->getImageUrl($this->breadcrumb),
            'meta_des'=>$this->meta_des,
            'meta_title'=>$this->meta_title,
            'created_at' =>  $this->created_at->format('Y-m-d'),
            'updated_at' =>  $this->updated_at->format('Y-m-d'),
            
        ];
    }
}