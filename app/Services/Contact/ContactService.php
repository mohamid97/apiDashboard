<?php
namespace App\Services\Contact;

use App\Models\Api\Admin\ContactUs;
use App\Services\BaseModelService;
use App\Traits\HandlesImage;
use App\Traits\StoreMultiLang;
use Illuminate\Database\Eloquent\Builder;

class ContactService extends BaseModelService
{
    use StoreMultiLang , HandlesImage;
    protected string $modelClass = ContactUs::class;
   

        // get basic column that has no translation 
    private function getBasicColumn($data){
        $basicData = array_intersect_key($data, array_flip([
            'image', 
       ]));
       return $basicData;
    }

    public function all($request){
        $allDetails = ContactUs::first();
        return $allDetails;
    }


    public function store(array $data)
    {
        if(isset($data['image']) && $data['image'] != ''){
            $data['image'] = $this->uploadImage($data['image'] , 'uploads/contact');
        }
        
        $contact = ContactUs::updateOrCreate(['id' => 1] , $data);
        $this->processTranslations($contact, $data, ['title', 'des' , 'alt_image' , 'title_image'  , 'meta_title' , 'meta_des']);  
       
        return $contact;
        
        
    }














    
    

    
}