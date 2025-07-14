<?php
namespace App\Services\Role;
use App\Services\BaseModelService;
use Spatie\Permission\Models\Role;

class RoleService extends BaseModelService
{
    protected string $modelClass = Role::class;

    public function store()
    {

       $role =  parent::store($this->data); 
        if (isset($this->data['permissions']) && is_array($this->data['permissions'])) {
            $role->syncPermissions($this->data['permissions']);
        } 
        return $role;
    }


    public function update($id){
        $role = parent::update($id , $this->getBasicColumn(['name']));
        if (!empty($this->data['permissions']) && is_array($this->data['permissions'])) {
            $role->syncPermissions($this->data['permissions']);
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