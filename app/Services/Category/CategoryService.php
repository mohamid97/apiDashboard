<?php
namespace App\Services\Category;

use App\Models\Api\Admin\Category;
use App\Services\BaseModelService;
use App\Traits\StoreMultiLang;
use Illuminate\Database\Eloquent\Builder;

class CategoryService extends BaseModelService
{
    use StoreMultiLang;
    protected string $modelClass = Category::class;



    public function all($request){
        $allDetails = parent::all($request);
        return $allDetails;
    }

    public function view($id){
        $categoryDetails = parent::view($id);
        return $categoryDetails;
    }

    public function store()
    {
        $this->uploadSingleImage(['image' , 'thumbnail' , 'breadcrumb'], 'uploads/categories'); 
        $category = parent::store($this->getBasicColumn($this->data , ['image', 'thumbnail', 'breadcrumb' , 'order']));
        $this->data['slug']  = $this->createSlug($this->data);
        $this->processTranslations($category, $this->data, ['title', 'slug', 'des' , 'alt_image' , 'title_image' , 'small_des' , 'meta_title' , 'meta_des']);  
        return $category;
        
    }


    public function update($id){
        $this->uploadSingleImage(['image' , 'thumbnail' , 'breadcrumb'], 'uploads/categories'); 
        $category = parent::update($id , $this->getBasicColumn( $this->data , ['image', 'thumbnail', 'breadcrumb' , 'order']));
        $this->processTranslations($category, $this->data, ['title' , 'slug', 'des' , 'alt_image' , 'title_image' , 'small_des' , 'meta_title' , 'meta_des']);
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

    public function orderBy(Builder $query, string $orderBy, string $direction = 'asc')
    {
        return $query->orderBy($orderBy, $direction);
    }









    
    

    
}