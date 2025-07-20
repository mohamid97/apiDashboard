<?php

namespace App\Http\Resources\Api\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Traits\HandlesImage;
class CategoryResource extends JsonResource
{
    use HandlesImage;
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        $parentData= null;
        if ( $this->parent) {
            $parentData = [
                'id' => $this->parent->id,
                'name' => $this->parent->title,
                'slug' => $this->parent->slug
            ];
        }
        
        return [
            'id' => $this->id,
            'slug' => $this->getColumnLang('slug'),
            'title' => $this->getColumnLang('title'),
            'des' => $this->getColumnLang('des'),
            'meta_title' => $this->getColumnLang('meta_title'),
            'parent' => $parentData, // Will be null if no parent exists
            'meta_des' => $this->getColumnLang('meta_des'),
            'image' => $this->getImageUrl($this->image),
            'title_image' => $this->getColumnLang('title_image'),
            'alt_image' => $this->getColumnLang('alt_image'),
            'thumbnail' => $this->getImageUrl($this->thumbnail),
            'order' => $this->order,
            'created_at' => $this->created_at->format('Y-m-d'),
            'updated_at' => $this->updated_at->format('Y-m-d'),
        ];

    }
    
}