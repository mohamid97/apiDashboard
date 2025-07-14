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



    public function all($request){
        $feedback = parent::all($request);
        return $feedback;
    }

    public function view($id){
        $details = parent::view($id);
        return $details;
    }

    public function store()
    {
 
        if(isset($data['images']) &&  is_array($data['images'])){
            $data['images'] = $this->uploadFeedbackImages($this->data);  
        }
        $this->uploadSingleImage(['breadcrumb'], 'uploads/feedbacks');  
        $feed = parent::store($this->getBasicColumn(['images','breadcrumb']));
        $this->processTranslations($feed, $this->data, ['title', 'small_des' ,'des','meta_des' , 'meta_title']);  
        return $feed;
        
    }
    


    public function update($id){ 
        
        if(isset($data['images']) &&  is_array($data['images'])){      
            $data['images'] = $this->uploadFeedbackImages($data);  
        }
        $this->uploadSingleImage(['breadcrumb'], 'uploads/feedbacks');  
        $feed = parent::update($id , $this->getBasicColumn(['images','breadcrumb']));
        $this->processTranslations($feed, $this->data, ['title', 'small_des' ,'des','meta_des' , 'meta_title']);
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