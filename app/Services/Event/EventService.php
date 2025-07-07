<?php
namespace App\Services\Event;

use App\Models\Api\Admin\Event;
use App\Services\BaseModelService;
use App\Traits\HandlesImage;
use App\Traits\StoreMultiLang;

class EventService extends BaseModelService{

    use StoreMultiLang , HandlesImage;
    protected string $modelClass = Event::class;


            // get basic column that has no translation 
    private function getBasicColumn($data){
        $basicData = array_intersect_key($data, array_flip([
            'images', 'breadcrumb', 'date'
       ]));
       return $basicData;
    }
    private function uploadEventImages(&$data){
        
        $data['images'] = array_map(function($image) {
            return $this->uploadImage($image, 'uploads/events');
        }, $data['images']);
        return $data['images'];

        
    }

    public function all($request){
        $eventDetails = parent::all($request);
        return $eventDetails;
    }

    public function view($id){
        $eventDetails = parent::view($id);
        return $eventDetails;
    }

    public function store(array $data)
    {
  
      if(isset($data['images']) && is_array($data['images'])){  
        $data['images'] = $this->uploadEventImages($data);
       }
       
        $event = parent::store($this->getBasicColumn($data));
        $this->processTranslations($event, $data, ['title', 'des' ,'meta_title' , 'meta_des', 'alt_image' , 'title_image']);  
        return $event;
        
    }
    


    public function update($id , array $data){
        if(isset($data['images']) && is_array($data['images'])){
          $data['images'] = $this->uploadEventImages($data);
        }
        $event = parent::update($id , $this->getBasicColumn($data));
        $this->processTranslations($event, $data, ['title', 'des' , 'meta_title' , 'meta_des' , 'alt_image' , 'title_image']);
        return $event;
        
    }

    public function delete($id){
        $event = Event::findOrFail($id);
        foreach($event->images as $image) {
           // dd($image);
            $this->deleteImage($image);
        }
        $this->deleteImage($event->breakcrumb);
        $event = parent::delete($id);
        return $event;
    }



    
}