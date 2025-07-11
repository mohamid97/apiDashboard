<?php

namespace App\Models\Api\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
class Ourwork extends Model implements TranslatableContract
{
    use HasFactory,Translatable;
    protected $fillable = ['images' , 'link', 'breadcrumb'];
    public $translatedAttributes = ['title' , 'des' , 'meta_title' , 'meta_des'];
    public $translationForeignKey = 'ourwork_id';
    public $translationModel = 'App\Models\Api\Admin\OurworkTranslation';
    protected $casts = [
        'images' => 'array',
    ];

    
    protected function serializeDate(\DateTimeInterface $date)
    {
      return $date->format('Y-m-d'); 
    }

    
}