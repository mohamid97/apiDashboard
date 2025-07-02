<?php
namespace App\Services\About;

use App\Models\Api\Admin\AboutUs;
use App\Services\BaseModelService;
use App\Traits\HandlesImage;
use App\Traits\StoreMultiLang;
use Illuminate\Database\Eloquent\Builder;

class AboutService extends BaseModelService
{
    use StoreMultiLang , HandlesImage;
    protected string $modelClass = AboutUs::class;
   

        // get basic column that has no translation 
    private function getBasicColumn($data){
        $basicData = array_intersect_key($data, array_flip([
            'image', 
            'breadcrumb', 

       ]));
       return $basicData;
    }

    public function all($request){
        $allDetails = AboutUs::first();
        return $allDetails;
    }


    public function store(array $data)
    {
        if(isset($data['image']) && $data['image'] != ''){
            $data['image'] = $this->uploadImage($data['image'] , 'uploads/about');
        }
        if(isset($data['breadcrumb']) && $data['breadcrumb'] != ''){
            $data['breadcrumb'] = $this->uploadImage($data['breadcrumb'] , 'uploads/about');
        }
        
        $about = AboutUs::updateOrCreate(['id' => 1] , $data);
        $this->processTranslations($about, $data, ['title', 'des' , 'alt_image' , 'title_image'  , 'meta_title' , 'meta_des']);  
        return $about;
        
    }














    
    

    
}