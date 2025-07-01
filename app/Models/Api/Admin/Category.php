<?php

namespace App\Models\Api\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
class Category extends Model implements TranslatableContract
{
    use HasFactory , Translatable;
    protected $fillable = ['image' , 'thumbnail' , 'order'];
    public $translatedAttributes = ['title' , 'alt_image' , 'title_image' ,'small_des' , 'des' , 'meta_title' , 'meta_des' , 'slug'];
    public $translationForeignKey = 'category_id';
    public $translationModel = 'App\Models\Api\Admin\CategoryTranslation';

    
    protected function serializeDate(\DateTimeInterface $date)
    {
      return $date->format('Y-m-d'); 
    }
    
}