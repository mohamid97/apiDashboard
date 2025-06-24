<?php
namespace App\Services\Slider;

use App\Models\Api\Admin\Slider;
use App\Services\BaseModelService;
use App\Traits\HandlesImage;
use App\Traits\StoreMultiLang;

class SliderService extends BaseModelService
{
    use StoreMultiLang , HandlesImage;
    protected string $modelClass = Slider::class;
   

    public function store(array $data)
    {
         
        $data['image'] = $this->uploadImage($data['image'] , 'uploads');
        $slider = parent::store($this->getBasicColumn($data));
        $this->processTranslations($slider, $data, ['title', 'des' , 'alt_image' , 'title_image' , 'small_des']);  
        return $slider;
        
    }


    // get basic column that has no translation 
    private function getBasicColumn($data){
        $basicData = array_intersect_key($data, array_flip([
            'image', 
            'link', 
            'video', 
            'order'
       ]));
       return $basicData;
    }

    
    

    
}