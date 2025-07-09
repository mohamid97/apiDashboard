<?php

namespace App\Services\Ourwork;

use App\Models\Api\Admin\Ourwork;
use App\Services\BaseModelService;
use App\Traits\HandlesImage;
use App\Traits\StoreMultiLang;
use Illuminate\Database\Eloquent\Builder;

class OurworkService extends BaseModelService{
    use StoreMultiLang , HandlesImage;
    protected string $modelClass = Ourwork::class;

    private function uploadOurworkImages(&$data){
        
        $data['images'] = array_map(function($image) {
            return $this->uploadImage($image, 'uploads/ourworks');
        }, $data['images']);
        return $data['images'];

        
    }
            // get basic column that has no translation 
    private function getBasicColumn($data){
        $basicData = array_intersect_key($data, array_flip([
            'images',
            'link',
            'breadcrumb'
       ]));
       return $basicData;
    }


    public function all($request){
        $ourworks = parent::all($request);
        return $ourworks;
    }

    public function view($id){
        $details = parent::view($id);
        return $details;
    }

    public function store(array $data)
    {

    
        if(isset($data['images']) &&  is_array($data['images'])){
            $data['images'] = $this->uploadOurworkImages($data);  
        }

        if(isset($data['breadcrumb']) &&  $data['breadcrumb'] != null){
          $data['breadcrumb'] = $this->uploadImage($data['breadcrumb'], 'uploads/ourworks');
        }
       
        $ourwork = parent::store($this->getBasicColumn($data));
        $this->processTranslations($ourwork, $data, ['title', 'des','meta_des' , 'meta_title']);  
        return $ourwork;
        
    }
    


    public function update($id , array $data){
        if(isset($data['images']) &&   is_array($data['image'])){
            $data['images'] = $this->uploadOurworkImages($data);       
        }
        if(isset($data['breadcrumb']) &&  $data['breadcrumb'] != null){
          $data['breadcrumb'] = $this->uploadImage($data['breadcrumb'], 'uploads/ourworks');
        }
        $ourwork = parent::update($id , $this->getBasicColumn($data));
        $this->processTranslations($ourwork, $data, ['title', 'des','meta_des' , 'meta_title']);
        return $ourwork;
        
    }

    public function delete($id){
        $ourwork = Ourwork::findOrFail($id);
        $this->deleteImage($ourwork->breadcrumb);
        foreach($ourwork->images as $image) {
            $this->deleteImage($image);
        }
        $ourwork = parent::delete($id);
        return $ourwork;
        
    }


    public function applySearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->whereHas('translations', function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('des', 'like', "%{$search}%");
            });
        });
        
    }


    public function orderBy(Builder $query, string $orderBy, string $direction)
    {
        return $query->orderBy($orderBy, $direction);
    }
    
    

}