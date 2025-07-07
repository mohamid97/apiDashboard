<?php

namespace App\Http\Requests;

use App\Http\Requests\Api\Admin\About\AboutStoreRequest;
use App\Http\Requests\Api\Admin\About\AboutUpdateRequest;
use App\Http\Requests\Api\Admin\Blog\BlogStoreRequest;
use App\Http\Requests\Api\Admin\Blog\BlogUpdateRequest;
use App\Http\Requests\Api\Admin\Category\CategoryStoreRequest;
use App\Http\Requests\Api\Admin\Category\CategoryUpdateRequest;
use App\Http\Requests\Api\Admin\Contact\ContactStoreRequest;
use App\Http\Requests\Api\Admin\Contact\ContactUpdateRequest;
use App\Http\Requests\Api\Admin\Event\EventStoreRequest;
use App\Http\Requests\Api\Admin\Event\EventUpdateRequest;
use App\Http\Requests\Api\Admin\Location\LocationStoreRequest;
use App\Http\Requests\Api\Admin\Location\LocationUpdateRequest;
use App\Http\Requests\Api\Admin\LangStoreRequest;
use App\Http\Requests\Api\Admin\Role\RoleStoreRequest;
use App\Http\Requests\Api\Admin\Role\RoleUpdateRequest;
use App\Http\Requests\Api\Admin\Slider\SliderStoreRequest;
use App\Http\Requests\Api\Admin\Slider\SliderUpdateRequest;
use App\Http\Requests\Api\Admin\Social\SocialStoreRequest;
use App\Http\Requests\Api\Admin\Users\UserStoreRequest;
use App\Http\Requests\Api\Admin\Users\UserUpdateRequest;
use App\Models\Api\Admin\Blog;
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
            ],
            'about'=>[
                'store'=>AboutStoreRequest::class,
                'update'=>AboutUpdateRequest::class
            ],
            'contact'=>[
                'store'=>  ContactStoreRequest::class,
                'update'=> ContactUpdateRequest::class
            ],
            'location'=>[
                'store'=> LocationStoreRequest::class,
                'update'=> LocationUpdateRequest::class
            ],
            'social'=>[
                'store'=>SocialStoreRequest::class
            ],
            'role'=>[
                'store'=> RoleStoreRequest::class,
                'update'=> RoleUpdateRequest::class
            ],
            'event'=>[
                'store' =>EventStoreRequest::class,
                'update' => EventUpdateRequest::class, 
            ],
            'blog'=>[
                'store'=> BlogStoreRequest::class,
                'update'=> BlogUpdateRequest::class
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