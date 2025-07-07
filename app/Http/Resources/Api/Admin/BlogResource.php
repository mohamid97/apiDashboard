<?php

namespace App\Http\Resources\Api\Admin;

use App\Models\Api\Admin\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Traits\HandlesImage;

class BlogResource extends JsonResource
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
            'id' => $this->id,
            'slug' => $this->slug,
            'small_des' => $this->small_des,
            'des' => $this->des,
            'image' => $this->getImageUrl($this->image),
            'breadcrumb' => $this->getImageUrl($this->breadcrumb),
            'category_id' => new CategoryResource(Category::find($this->category_id)),
            'meta_title' => $this->meta_title,
            'meta_des' => $this->meta_des,
            'alt_image' => $this->alt_image,
            'title_image' => $this->title_image,
            'title' => $this->title,
            'created_at' =>  $this->created_at->format('Y-m-d'),
            'updated_at' =>  $this->updated_at->format('Y-m-d'),
        ];
    }
}