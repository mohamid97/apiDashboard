<?php

namespace App\Http\Resources\Api\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SocialResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
            return [
                'facebook' => $this->facebook,
                'twitter' => $this->twitter,
                'instagram' => $this->instagram,
                'youtube' => $this->youtube,
                'linkedin' => $this->linkedin,
                'tiktok' => $this->tiktok,
                'pinterest' => $this->pinterest,
                'snapchat' => $this->snapchat,
                'email' => $this->email,
                'phone' => $this->phone,
                'facebook_cta' => $this->facebook_cta,
                'twitter_cta' => $this->twitter_cta,
                'instagram_cta' => $this->instagram_cta,
                'youtube_cta' => $this->youtube_cta,
                'linkedin_cta' => $this->linkedin_cta,
                'tiktok_cta' => $this->tiktok_cta,
                'pinterest_cta' => $this->pinterest_cta,
                'snapchat_cta' => $this->snapchat_cta,
                'email_cta' => $this->email_cta,
                'phone_cta' => $this->phone_cta,
                'facebook_layout' => (bool)$this->facebook_layout,
                'twitter_layout' => (bool)$this->twitter_layout,
                'instagram_layout' => (bool)$this->instagram_layout,
                'youtube_layout' => (bool)$this->youtube_layout,
                'linkedin_layout' => (bool)$this->linkedin_layout,
                'tiktok_layout' => (bool)$this->tiktok_layout,
                'pinterest_layout' => (bool)$this->pinterest_layout,
                'snapchat_layout' => (bool)$this->snapchat_layout,
                'email_layout' => (bool)$this->email_layout,
                'phone_layout' => (bool)$this->phone_layout
            ];
      
      
    }

    
}