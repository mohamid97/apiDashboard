<?php

class UserService extends BaseModelService
{
    protected string $modelClass = User::class;

    public function store(array $data)
    {
        $this->authorizeAction('create');
        $data['password'] = bcrypt($data['password']);
        return parent::store($data);
    }

    
}