<?php
namespace App\Services\Social;

use App\Models\Api\Admin\Soical;
use App\Services\BaseModelService;
class SocialService extends BaseModelService{
    protected string $modelClass = Soical::class;

    public function store()
    {
        Soical::query()->delete(); 
        return parent::store($this->data); 
    }
    
}