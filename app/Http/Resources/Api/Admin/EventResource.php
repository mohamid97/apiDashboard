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
        if($this->images){
            foreach ($this->images as $image) {
                
                $images[] = $this->getImageUrl($image);
            }  
        }
        return [
            'id' => $this->id,
            'title' => $this->getColumnLang('title'),
            'des' => $this->getColumnLang('des'),
            'images' => $images,
            'breadcrumb' => $this->getImageUrl($this->breadcrumb),
            'date' => $this->date ? $this->date->format('Y-m-d') : null,
            'meta_title' => $this->getColumnLang('meta_title'),
            'meta_des' => $this->getColumnLang('meta_des'),
            'alt_image' => $this->getColumnLang('alt_image'),
            'title_image' => $this->getColumnLang('title_image'),
            'created_at' => $this->created_at->format('Y-m-d'),
            'updated_at' => $this->updated_at->format('Y-m-d'),
        ];

        
    }



}