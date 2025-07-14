<?php
namespace App\Services\Product;

use App\Models\Api\Admin\Product;
use App\Services\BaseModelService;
use App\Traits\HandlesImage;
use App\Traits\StoreMultiLang;
use Illuminate\Database\Eloquent\Builder;
class ProductService extends BaseModelService
{
        use StoreMultiLang , HandlesImage;
    protected string $modelClass = Product::class;


     // get basic column that has no translation 
    private function getBasicColumn($data){
        $basicData = array_intersect_key($data, array_flip([
            'images', 'product_image', 'breadcrumb', 'price','category_id','order'
       ]));
       return $basicData;
    }

    private function createSlug($data){
        $slug = [];
        foreach($data['title'] as $key => $value){          
            if(!empty($value) && !isset($data['slug'][$key])){
                $slug[$key] = str_replace(' ', '-', strtolower($value));
            }else{
                $slug[$key] = $data['slug'][$key];
            }
        }

        return $slug;
    }

    private function uploadImages(&$data){
        
        $data['images'] = array_map(function($image) {
            return $this->uploadImage($image, 'uploads/services');
        }, $data['images']);
        return $data['images'];

        
    }
    public function all($request){
        $serivces = parent::all($request);
        return $serivces;
    }

    public function view($id){
        $serviceDetails = parent::view($id);
        return $serviceDetails;
    }

    public function store(array $data)
    {

        if(isset($data['product_image'])){  
            $data['product_image'] = $this->uploadImage($data['product_image'] , 'uploads/products');
        }
        if(isset($data['breadcrumb'])){  
            $data['breadcrumb'] = $this->uploadImage($data['breadcrumb'] ,'uploads/products');
        } 
        if(isset($data['images']) && is_array($data['images'])) {  
            $data['images'] = $this->uploadImages($data,'uploads/products');
        }
        
        $data['slug']  = $this->createSlug($data);
        $product = parent::store($this->getBasicColumn($data));
        $this->processTranslations($product, $data, ['title', 'slug' ,'des' , 'small_des' , 'meta_title' , 'meta_des', 'alt_image' , 'title_image']);  
        return $product;
        
    }
    


    public function update($id , array $data){
        if(isset($data['product_image'])){  
            $data['service_image'] = $this->uploadImage($data['service_image'] , 'uploads/products');
        }
        if(isset($data['breadcrumb'])){  
            $data['breadcrumb'] = $this->uploadImage($data['breadcrumb'] ,'uploads/products');
        } 
        if(isset($data['images']) && is_array($data['images'])) {  
            $data['images'] = $this->uploadImages($data,'uploads/products');
        }
        $product = parent::update($id , $this->getBasicColumn($data));
        $this->processTranslations($product, $data, ['title', 'slug' ,'des' , 'small_des' , 'meta_title' , 'meta_des', 'alt_image' , 'title_image']);
        return $product;
        
    }

    public function delete($id){
        $product = Product::findOrFail($id);
        $this->deleteImage($product->breakcrumb);
        $this->deleteImage($product->image);
        $product = parent::delete($id);
        return $product;
    }


    public function applySearch(Builder $query, string $search ){
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