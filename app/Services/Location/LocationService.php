<?php
namespace App\Services\Location;

use App\Models\Api\Admin\Location;
use App\Services\BaseModelService;
use App\Traits\HandlesImage;
use App\Traits\StoreMultiLang;

class LocationService extends BaseModelService
{
    use StoreMultiLang , HandlesImage;
    protected string $modelClass = Location::class;
    
   

        // get basic column that has no translation 
    private function getBasicColumn($data){
        $basicData = array_intersect_key($data, array_flip([
            'location', 

       ]));
       return $basicData;
    }

    // public function all($request){
    //     $allDetails = parent::all($request);
    //     return $allDetails;
    // }

    // public function view($id){
    //     $sliderDetails = parent::view($id);
    //     return $sliderDetails;
    // }

    public function store(array $data)
    {
        
        $location = parent::store($this->getBasicColumn($data));
        $this->processTranslations($location, $data, ['address']);
        if (!empty($data['phones']) && is_array($data['phones'])) {
            foreach ($data['phones'] as $phone) {
                $location->phones()->create([
                    'phone' => $phone
                ]);
            }
        }

        if (!empty($data['email']) && is_array($data['email'])) {
            foreach ($data['email'] as $email) {
                $location->emails()->create([
                    'email' => $email
                ]);
            }
        }
        return $location;
        
    }

    


    public function update($id , array $data){
        if(isset($data['image']) && $data['image'] != ''){
            $data['image'] = $this->uploadImage($data['image'] , 'uploads');
        }
        $slider = parent::update($id , $this->getBasicColumn($data));
        $this->processTranslations($slider, $data, ['title', 'des' , 'alt_image' , 'title_image' , 'small_des']);
        return $slider;
        
    }

    public function delete($id){
        $slider = parent::delete($id);
        return $slider;
    }








    
    

    
}