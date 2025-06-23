<?php


namespace App\Services;

use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Access\AuthorizationException;

abstract class BaseModelService
{
    protected string $modelClass;

    // protected function authorizeAction(string $action)
    // {
    //     $model = strtolower(class_basename($this->modelClass));
    //     $permission = "$model.$action";

    //     if (!Auth::user()?->can($permission)) {
    //         throw new AuthorizationException("You do not have permission to $action $model");
    //     }
    // }

    public function store(array $data)
    {
        // $this->authorizeAction('create');
        return $this->modelClass::create($data);
    }

    public function update(int $id, array $data)
    {
        // $this->authorizeAction('update');
        $item = $this->modelClass::findOrFail($id);
        $item->update($data);
        return $item;
    }

    public function delete(int $id)
    {
        // $this->authorizeAction('delete');
        $item = $this->modelClass::findOrFail($id);
        $item->delete();
        return true;
    }
}