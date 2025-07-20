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

    public function all($request){
        $product = parent::all($request);
        return $product;
    }

    public function view($id){
        $productDetails = parent::view($id);
        return $productDetails;
    }

    public function store()
    {
      

        $this->uploadSingleImage(['product_image', 'breadcrumb'], 'uploads/products');
        if(isset($this->data['images']) && is_array($this->data['images'])) {  
            $this->data['images'] = $this->uploadImages( $this->data , 'uploads/products');
        }
        $this->data['slug']  = $this->createSlug($this->data); 
        $product = parent::store($this->getBasicColumn(['images' , 'product_image', 'breadcrumb' , 'order' , 'type' , 'value' , 'price'  , 'category_id']));
        $this->processTranslations($product, $this->data, ['title', 'slug' ,'des' , 'small_des' , 'meta_title' , 'meta_des', 'alt_image' , 'title_image']);  
        return $product;
        
    }
    


    public function update($id ){
        $this->uploadSingleImage(['product_image', 'breadcrumb'], 'uploads/products');
        if(isset($this->data['images']) && is_array($this->data['images'])) {  
            $this->data['images'] = $this->uploadImages($this->data,'uploads/products');
        }
        $product = parent::update($id , $this->getBasicColumn(['images' , 'product_image', 'breadcrumb' , 'order' , 'type' , 'value' , 'price'  , 'category_id']));
        $this->processTranslations($product, $this->data, ['title', 'slug' ,'des' , 'small_des' , 'meta_title' , 'meta_des', 'alt_image' , 'title_image']);
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