<?php
namespace App\Services\Location;

use App\Models\Api\Admin\Location;
use App\Services\BaseModelService;
use App\Traits\StoreMultiLang;
use Illuminate\Support\Str;


class LocationService extends BaseModelService
{
    use StoreMultiLang;
    protected string $modelClass = Location::class;
    
   

        // get basic column that has no translation 
    private function getBasicColumn($data){
        $basicData = array_intersect_key($data, array_flip([
            'location', 

       ]));
       return $basicData;
    }


    public function store(array $data)
    {     
        $location = parent::store($this->getBasicColumn($data));
        $this->processTranslations($location, $data, ['address']);   
        $location =  $this->storeRelations($data, ['phones' , 'emails'], $location);
        return $location;
        
    }

    


    public function update($id , array $data){    
        
        $location = parent::update($id , $this->getBasicColumn($data));
        $this->processTranslations($location, $data, ['address']);
        $location =  $this->storeRelations($data, ['phones' , 'emails'], $location);
        return $location;
        
    }

    public function delete($id){
        $location = parent::delete($id);
        return $location;
    }

    

    private function storeRelations($data , $relations , $location){
            
        foreach($relations as $relation){   
            if (!method_exists($location, $relation)) {
                continue; 
            }
            $location->$relation()->delete();        
            if (!empty($data[$relation]) && is_array($data[$relation])) {
                foreach ($data[$relation] as $item) {      
                    $location->$relation()->create([
                        Str::singular($relation) => $item
                    ]);
                }
            } 

        } // end loop of realtions

        return $location;
                

    }








    
    

    
}