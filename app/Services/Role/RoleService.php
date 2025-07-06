<?php
namespace App\Services\Role;
use App\Services\BaseModelService;
use Spatie\Permission\Models\Role;

class RoleService extends BaseModelService
{
    protected string $modelClass = Role::class;
    private function getBasicColumn($data){
        $basicData = array_intersect_key($data, array_flip([
            'name'
       ]));
       return $basicData;
    }
    public function store(array $data)
    {

       $role =  parent::store($data); 
        if (isset($data['permissions']) && is_array($data['permissions'])) {
            $role->syncPermissions($data['permissions']);
        } 
        return $role;
    }


    public function update($id , array $data){
        $role = parent::update($id , $this->getBasicColumn($data));
        if (!empty($data['permissions']) && is_array($data['permissions'])) {
            $role->syncPermissions($data['permissions']);
        }
        return $role;
        
    }


    public function delete($id){
        $role = $this->modelClass::findOrFail($id);
        $role->permissions()->detach();
        $role = parent::delete($id);
        return $role;
    }

    

    
}