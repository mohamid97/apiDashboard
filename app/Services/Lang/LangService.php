<?php

namespace App\Services\Lang;

use App\Models\Api\Admin\Lang;
use App\Services\BaseModelService;    

class LangService extends BaseModelService
{
    protected string $modelClass = Lang::class;

    public function store(array $data)
    {
        
        $data['code'] = strtolower($data['code']);
        $lang = parent::store($data);
        return $lang;
    }
    

    public function update(int $id, array $data)
    {
        $data['code'] = strtolower($data['code']);
        return parent::update($id, $data);
    }

    

    
}