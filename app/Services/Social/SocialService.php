<?php
namespace App\Services\Social;

use App\Models\Api\Admin\Soical;
use App\Services\BaseModelService;
class SocialService extends BaseModelService{
    protected string $modelClass = Soical::class;

    public function store(array $data)
    {
        Soical::query()->delete(); 
        return parent::store($data); 
    }
    
}