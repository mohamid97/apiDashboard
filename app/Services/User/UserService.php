<?php
namespace App\Services\User;

use App\Models\User;
use App\Services\BaseModelService;

class UserService extends BaseModelService
{
    protected string $modelClass = User::class;

    public function store(array $data)
    {
        $data['password'] = bcrypt($data['password']);
        $user = parent::store($data);
        $user->roles()->syncRoles($data['role_id']);
        return $user;
    }
    

    
}