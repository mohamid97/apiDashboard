<?php

namespace App\Http\Resources\Api\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Traits\HandlesImage;

class ServiceResource extends JsonResource
{
    use HandlesImage;
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
 
        if(isset($this->images) && is_array($this->images)) {
            $this->images = array_map(function($image) {
                return $this->getImageUrl($image);
            }, $this->images);
        }

        
        return [
            'id' => $this->id,
            'title' => $this->getColumnLang('title'),
            'slug' => $this->slug,
            'price' => $this->price,
            'category_id' => $this->category_id,
            'order' => $this->order,
            'small_des' => $this->getColumnLang('small_des'),
            'des' => $this->getColumnLang('des'),
            'images' => $this->images,
            'image' => $this->getImageUrl($this->service_image),
            'breadcrumb' => $this->getImageUrl($this->breadcrumb),
            'title_image' => $this->getColumnLang('title_image'),
            'alt_image' => $this->getColumnLang('alt_image'),
            'meta_title' => $this->getColumnLang('meta_title'),
            'meta_des' => $this->getColumnLang('meta_des'),
            'created_at' => $this->created_at->format('Y-m-d'),
            'updated_at' => $this->updated_at->format('Y-m-d'),
        ];
    }
}