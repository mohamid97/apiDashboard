<?php
namespace App\Services\Category;

use App\Models\Api\Admin\Category;
use App\Services\BaseModelService;
use App\Traits\HandlesImage;
use App\Traits\StoreMultiLang;
use Illuminate\Database\Eloquent\Builder;

class CategoryService extends BaseModelService
{
    use StoreMultiLang , HandlesImage;
    protected string $modelClass = Category::class;
   

        // get basic column that has no translation 
    private function getBasicColumn($data){
        $basicData = array_intersect_key($data, array_flip([
            'image', 
            'thumbnail', 
            'order'
       ]));
       return $basicData;
    }

    public function all($request){
        $allDetails = parent::all($request);
        return $allDetails;
    }

    public function view($id){
        $categoryDetails = parent::view($id);
        return $categoryDetails;
    }

    public function store(array $data)
    {
        if(isset($data['image']) && $data['image'] != ''){
            $data['image'] = $this->uploadImage($data['image'] , 'uploads/category');
        }
        if(isset($data['thumbnail']) && $data['thumbnail'] != ''){
            $data['thumbnail'] = $this->uploadImage($data['thumbnail'] , 'uploads/category');
        }
        
        $category = parent::store($this->getBasicColumn($data));
        $this->processTranslations($category, $data, ['title', 'slug', 'des' , 'alt_image' , 'title_image' , 'small_des' , 'meta_title' , 'meta_des']);  
        return $category;
        
    }


    public function update($id , array $data){
        if(isset($data['image']) && $data['image'] != ''){
            $data['image'] = $this->uploadImage($data['image'] , 'uploads/category');
        }
        if(isset($data['thumbnail']) && $data['thumbnail'] != ''){
            $data['thumbnail'] = $this->uploadImage($data['thumbnail'] , 'uploads/category');
        }
        $category = parent::update($id , $this->getBasicColumn($data));
        $this->processTranslations($category, $data, ['title' , 'slug', 'des' , 'alt_image' , 'title_image' , 'small_des' , 'meta_title' , 'meta_des']);
        return $category;
        
    }

    public function delete($id){
        $category = parent::delete($id);
        return $category;
    }

    public function applySearch(Builder $query, string $search){
        return $query->where(function ($q) use ($search) {
            $q->whereTranslationLike('title', "%$search%")
              ->orWhereTranslationLike('slug', "%$search%");
        });
    }








    
    

    
}