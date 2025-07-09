<?php

namespace App\Services\Feedback;

use App\Models\Api\Admin\Feedback;
use App\Services\BaseModelService;
use App\Traits\HandlesImage;
use App\Traits\StoreMultiLang;
use Illuminate\Database\Eloquent\Builder;

class FeedbackService extends BaseModelService{
    use StoreMultiLang , HandlesImage;
    
    protected string $modelClass = Feedback::class;

    
    private function uploadFeedbackImages(&$data){
            
        $data['images'] = array_map(function($image) {
            return $this->uploadImage($image, 'uploads/feedbacks');
        }, $data['images']);
        return $data['images'];
        
    }
    // get basic column that has no translation 
    private function getBasicColumn($data){
        $basicData = array_intersect_key($data, array_flip([
            'images',
            'breadcrumb'
       ]));
       return $basicData;
    }


    public function all($request){
        $feedback = parent::all($request);
        return $feedback;
    }

    public function view($id){
        $details = parent::view($id);
        return $details;
    }

    public function store(array $data)
    {
 
        if(isset($data['images']) &&  is_array($data['images'])){
            $data['images'] = $this->uploadFeedbackImages($data);  
        }

        if(isset($data['breadcrumb']) &&  $data['breadcrumb'] != null){
          $data['breadcrumb'] = $this->uploadImage($data['breadcrumb'], 'uploads/feedbacks');
        }
       
        $feed = parent::store($this->getBasicColumn($data));
        $this->processTranslations($feed, $data, ['title', 'small_des' ,'des','meta_des' , 'meta_title']);  
        return $feed;
        
    }
    


    public function update($id , array $data){ 
        
        if(isset($data['images']) &&  is_array($data['images'])){      
            $data['images'] = $this->uploadFeedbackImages($data);  
        }
        if(isset($data['breadcrumb']) &&  $data['breadcrumb'] != null){
          $data['breadcrumb'] = $this->uploadImage($data['breadcrumb'], 'uploads/feedbacks');
        } 
        $feed = parent::update($id , $this->getBasicColumn($data));
        $this->processTranslations($feed, $data, ['title', 'small_des' ,'des','meta_des' , 'meta_title']);
        return $feed;
        
    }

    public function delete($id){
        $feed = $this->modelClass::findOrFail($id);
        $this->deleteImage($feed->breadcrumb);
        foreach($feed->images as $image) {
            $this->deleteImage($image);
        }
        $feed = parent::delete($id);
        return $feed;
        
    }


    public function applySearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->whereHas('translations', function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('des', 'like', "%{$search}%")
                  ->orWhere('small_des' , 'like' , "%{$search}%");
            });
        });
        
    }


    public function orderBy(Builder $query, string $orderBy, string $direction)
    {
        return $query->orderBy($orderBy, $direction);
    }

    
    
    

}