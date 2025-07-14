<?php
namespace App\Services\Achivement;

use App\Models\Api\Admin\Achivement;
use App\Services\BaseModelService;
use App\Traits\HandlesImage;
use App\Traits\StoreMultiLang;
use Illuminate\Database\Eloquent\Builder;

class AchivementService extends BaseModelService{
    
    use StoreMultiLang , HandlesImage;
    protected string $modelClass = Achivement::class;
    
    private function uploadAchievementImages(&$data){
            
        $data['images'] = array_map(function($image) {
            return $this->uploadImage($image, 'uploads/achievements');
        }, $data['images']);
        return $data['images'];
        
    }


    public function all($request){
        $achievement = parent::all($request);
        return $achievement;
    }

    public function view($id){
        $details = parent::view($id);
        return $details;
    }

    public function store()
    {
 
        if(isset($data['images']) &&  is_array($data['images'])){
            $data['images'] = $this->uploadAchievementImages($data);  
        }

       $this->uploadSingleImage(['breadcrumb'], 'uploads/achievements');

       
        $ach = parent::store($this->getBasicColumn(['images','breadcrumb','number']));
        $this->processTranslations($ach, $this->data, ['title' ,'des','meta_des' , 'meta_title']);  
        return $ach;
        
    }
    


    public function update($id){ 
        
        if(isset($data['images']) &&  is_array($data['images'])){      
            $data['images'] = $this->uploadAchievementImages($data);  
        }
       $this->uploadSingleImage(['breadcrumb'], 'uploads/achievements');

        $ach = parent::update($id , $this->getBasicColumn(['images','breadcrumb','number']));
        $this->processTranslations($ach, $this->data, ['title' ,'des','meta_des' , 'meta_title']);
        return $ach;
        
    }

    public function delete($id){
        $ach = $this->modelClass::findOrFail($id);
        $this->deleteImage($ach->breadcrumb);
        foreach($ach->images as $image) {
            $this->deleteImage($image);
        }
        $ach = parent::delete($id);
        return $ach;
        
    }


    public function applySearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->whereHas('translations', function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('des', 'like', "%{$search}%");
            })->orWhere('number', $search);
        });
        
    }


    public function orderBy(Builder $query, string $orderBy, string $direction)
    {
        return $query->orderBy($orderBy, $direction);
    }
}