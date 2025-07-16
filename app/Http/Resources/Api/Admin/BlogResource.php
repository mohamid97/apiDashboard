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
            'small_des' => $this->getColumnLang('small_des'),
            'des' => $this->getColumnLang('des'),
            'image' => $this->getImageUrl($this->image),
            'breadcrumb' => $this->getImageUrl($this->breadcrumb),
            'category_id' => new CategoryResource(Category::find($this->category_id)),
            'meta_title' => $this->getColumnLang('meta_title'),
            'meta_des' => $this->getColumnLang('meta_des'),
            'alt_image' => $this->getColumnLang('alt_image'),
            'title_image' => $this->getColumnLang('title_image'),
            'title' => $this->getColumnLang('title'),
            'created_at' => $this->created_at->format('Y-m-d'),
            'updated_at' => $this->updated_at->format('Y-m-d'),
        ];
    }
}