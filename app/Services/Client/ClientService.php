<?php
namespace App\Services\Client;

use App\Models\Api\Admin\Client;
use App\Services\BaseModelService;
use App\Traits\HandlesImage;
use App\Traits\StoreMultiLang;
use Illuminate\Database\Eloquent\Builder;
class ClientService extends BaseModelService{

    use StoreMultiLang , HandlesImage;
    protected string $modelClass = Client::class;


            // get basic column that has no translation 
    private function getBasicColumn($data){
        $basicData = array_intersect_key($data, array_flip([
            'image'
       ]));
       return $basicData;
    }


    public function all($request){
        $clients = parent::all($request);
        return $clients;
    }

    public function view($id){
        $details = parent::view($id);
        return $details;
    }

    public function store(array $data)
    {

        if(isset($data['image']) &&  $data['image'] != null){
          $data['image'] = $this->uploadImage($data['image'], 'uploads/clients');
        }
       
        $client = parent::store($this->getBasicColumn($data));
        $this->processTranslations($client, $data, ['title', 'des','alt_image' , 'title_image']);  
        return $client;
        
    }
    


    public function update($id , array $data){
        if(isset($data['image']) &&  $data['image'] != null){
          $data['image'] = $this->uploadImage($data['image'], 'uploads/clients');
        }
        $client = parent::update($id , $this->getBasicColumn($data));
        $this->processTranslations($client, $data, ['title', 'des' , 'alt_image' , 'title_image']);
        return $client;
        
    }

    public function delete($id){
        $client = Client::findOrFail($id);
        $this->deleteImage($client->image);
        $event = parent::delete($id);
        return $client;
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