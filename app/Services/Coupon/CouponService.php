<?php
namespace App\Services\Coupon;

use App\Models\Api\Admin\Coupon;
use App\Services\BaseModelService;
use App\Traits\StoreMultiLang;

class CouponService extends BaseModelService{

    use StoreMultiLang;
    protected string $modelClass = Coupon::class;



    public function all($request){
        $couponDetails = parent::all($request);
        return $couponDetails;
    }

    public function view($id){
        $couponDetails = parent::view($id);
        return $couponDetails;
    }

    public function store()
    {
        $coupon = parent::store($this->getBasicColumn(['code','type','value','min_order_amount','usage_limit','is_active','start_date','end_date',])); 
        $this->processTranslations($coupon, $this->data, ['name', 'des']);  
        return $coupon;
          
    }
    


    public function update($id ){
        $coupon = parent::update($id , $this->getBasicColumn(['code','type','value','min_order_amount','usage_limit','is_active','start_date','end_date',]));
        $this->processTranslations($coupon, $this->data, ['name', 'des']);
        return $coupon;
        
    }

    public function delete($id){
        $coupon = parent::delete($id);
        return $coupon;

        
    }



    
}