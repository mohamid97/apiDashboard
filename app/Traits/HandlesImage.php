<?php

namespace App\Traits;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

trait HandlesImage{


    public function uploadImage($image, string $directory = 'uploads', string $disk = 'public'): ?string
    {
        if (!$image || !$image->isValid()) {
            return npathull;
        }
        $filename = Str::random(20) . '.' . $image->getClientOriginalExtension();  
        $path = $image->storeAs($directory, $filename, $disk);   
        return $path;
    }






    public function deleteImage(string $path, string $disk = 'public'): bool
    {
        if (Storage::disk($disk)->exists($path)) {
            return Storage::disk($disk)->delete($path);
        }
        
        return false;
        
    }


    public function getImageUrl(?string $path, string $disk = 'public'): ?string
    {
        if (!$path) {
            return null;
        }
     
        return Storage::disk($disk)->url($path);
    }

    

    


    




    
}