<?php
namespace App\Services\User;

use App\Models\User;
use App\Services\BaseModelService;
use Spatie\Permission\Models\Role;

class UserService extends BaseModelService
{
    protected string $modelClass = User::class;

    public function store(array $data)
    {
        $data['password'] = bcrypt($data['password']);
        $data['type'] = 'manager';
        $user = parent::store($data);
        $role = Role::where(['name' => $data['role']])->first();
        if (isset($role) && $role != null) {    
            $user->assignRole($role);
        }
        return $user;
    }


    
    

    
}