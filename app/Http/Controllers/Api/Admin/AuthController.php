<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Admin\UserResource;
use Illuminate\Http\Request;
use App\Traits\ResponseTrait;

class AuthController extends Controller
{

    use ResponseTrait;
    //
    public function login(Request $request)
    {

 
        $credentials = $request->only('email', 'password');
        if (auth()->attempt($credentials)) {
            $user = auth()->user();
            $token = $user->createToken('AdminToken')->plainTextToken;
            return $this->success([
                'token' => $token,
                'user'=>new UserResource($user),
                // 'user' => [
                    
                //     'id' => $user->id,
                //     'name' => $user->name,
                //     'email' => $user->email,
                //     'roles' => $user->getRoleNames(),
                //     'permissions' => $user->getAllPermissions()->pluck('name'), // Just permission names

                // ]
            ], 'Login successful');

        }

        return $this->error('Unauthorized', 401);
    }
}