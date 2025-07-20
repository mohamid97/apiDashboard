<?php

namespace App\Http\Resources\Api\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RoleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
    
            'name' => $this->name,
            // 'permissions' => $this->permissions->pluck('name'),
            // 'created_at' => $this->created_at->format('Y-m-d'),
            // 'updated_at' => $this->updated_at->format('Y-m-d'),
        ];
    }
}