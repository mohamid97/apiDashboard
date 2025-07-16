<?php


namespace App\Services;

use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Access\AuthorizationException;
use App\Traits\HandlesImage;


abstract class BaseModelService
{
    use HandlesImage;
    protected string $modelClass;
    protected array $data = [];


    public function setData(array $data): self
    {
        $this->data = $data;
        return $this;
    }
    public function all($request){

       $query = $this->modelClass::query();
        if (!empty($request['search']) && method_exists($this, 'applySearch')) {
            $query = $this->applySearch($query, $request['search']);
        }

        if (!empty($request['orderBy']) && method_exists($this, 'orderBy')) {
            $query = $this->orderBy($query, $request['orderBy'] , $request['orderDirection'] ?? 'DESC');
        }

        return isset($request['paginate']) ? $query->paginate($request['paginate']) : $query->get();

    }

    public function view($id){
        return $this->modelClass::find($id);
    }

    public function store()
    {
        return $this->modelClass::create($this->data);
    }

    public function update(int $id)
    {
        $item = $this->modelClass::findOrFail($id);
        $item->update($this->data);
        return $item;
    }

    public function delete(int $id)
    {
        $item = $this->modelClass::findOrFail($id);
        $item->delete();
        return true;
    }

    protected function getBasicColumn($mainData){
        $basicData = array_intersect_key($this->data, array_flip($mainData));
        return $basicData;
    }

    
    
    protected function uploadSingleImage($single_image, $directory = 'uploads'){
      
        foreach ($single_image as $field) {
            if (!empty($this->data[$field])) {
                $this->data[$field] = $this->uploadImage($this->data[$field], $directory);
               
            }
        }
    }

    
    

    


}