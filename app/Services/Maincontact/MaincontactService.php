<?php
namespace App\Services\Maincontact;

use App\Models\Api\Admin\BasicContact;
use App\Services\BaseModelService;
class MaincontactService extends BaseModelService
{
    protected string $modelClass = BasicContact::class;

    public function store(array $data)
    {

        BasicContact::query()->delete();
        return parent::store($data);
        
    }


    
}