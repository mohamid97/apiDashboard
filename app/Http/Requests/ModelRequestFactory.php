<?php

namespace App\Http\Requests;

use App\Http\Requests\Api\Admin\Category\CategoryStoreRequest;
use App\Http\Requests\Api\Admin\Category\CategoryUpdateRequest;
use App\Http\Requests\Api\Admin\LangStoreRequest;
use App\Http\Requests\Api\Admin\Slider\SliderStoreRequest;
use App\Http\Requests\Api\Admin\Slider\SliderUpdateRequest;
use App\Http\Requests\Api\Admin\Users\UserStoreRequest;
use App\Http\Requests\Api\Admin\Users\UserUpdateRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;


class ModelRequestFactory
{
    public static function validate(string $model, string $action, Request $request): void
    {
        $map = [
            'user' => [
                'store' => UserStoreRequest::class,
                'update' => UserUpdateRequest::class,
            ],
            'lang'=>[
                'store' => LangStoreRequest::class,
                'update' => LangStoreRequest::class,
                
            ],
            'slider'=>[
                'store'=> SliderStoreRequest::class,
                'update'=> SliderUpdateRequest::class
            ],
            'category'=>[
                'store'=> CategoryStoreRequest::class,
                'update'=> CategoryUpdateRequest::class
            ]

        ];

        $model = strtolower($model);
        if (!isset($map[$model][$action])) {
           
            return; 
        }
      

       
        $requestClass = app($map[$model][$action]);
    
        $validator = Validator::make($request->all(), $requestClass->rules());
    
        // if ($validator->fails()) {
            
        //     throw new ValidationException($validator);
        // }

        
        
    }
}