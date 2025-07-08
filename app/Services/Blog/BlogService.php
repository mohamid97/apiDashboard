<?php
namespace App\Services\Blog;

use App\Models\Api\Admin\Blog;
use App\Services\BaseModelService;
use App\Traits\HandlesImage;
use App\Traits\StoreMultiLang;
use Illuminate\Database\Eloquent\Builder;
class BlogService extends BaseModelService{
    
    use StoreMultiLang , HandlesImage;
    protected string $modelClass = Blog::class;


            // get basic column that has no translation 
    private function getBasicColumn($data){
        $basicData = array_intersect_key($data, array_flip([
            'image', 'breadcrumb', 'is_active', 'category_id'
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


    public function all($request){
        $blog = parent::all($request);
        return $blog;
    }

    public function view($id){
        $blogDetails = parent::view($id);
        return $blogDetails;
    }

    public function store(array $data)
    {
  

        if(isset($data['image'])){  
            $data['image'] = $this->uploadImage($data['image'] , 'uploads/blog');
        }
        if(isset($data['breadcrumb'])){  
            $data['breadcrumb'] = $this->uploadImage($data['breadcrumb'] ,'uploads/blog');
        } 
        $data['slug']  = $this->createSlug($data);
        $blog = parent::store($this->getBasicColumn($data));
        $this->processTranslations($blog, $data, ['title', 'slug' ,'des' , 'small_des' , 'meta_title' , 'meta_des', 'alt_image' , 'title_image']);  
        return $blog;
        
    }
    


    public function update($id , array $data){
        if(isset($data['image'])){  
            $data['image'] = $this->uploadImage($data['image'] , 'uploads/blog');
        }
        if(isset($data['breadcrumb'])){  
            $data['breadcrumb'] = $this->uploadImage($data['breadcrumb'] ,'uploads/blog');
        }
        $blog = parent::update($id , $this->getBasicColumn($data));
        $this->processTranslations($blog, $data, ['title', 'slug' ,'des' , 'small_des' , 'meta_title' , 'meta_des', 'alt_image' , 'title_image']);
        return $blog;
        
    }

    public function delete($id){
        $blog = Blog::findOrFail($id);
        $this->deleteImage($blog->breakcrumb);
        $this->deleteImage($blog->image);
        $blog = parent::delete($id);
        return $blog;
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