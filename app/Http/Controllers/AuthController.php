<?php

namespace App\Http\Controllers;

use App\Models\User;
use Tymon\JWTAuth\JWTAuth;
use Illuminate\Http\Request;
use App\Http\Requests\UserRegisterRequest;
use App\Http\Requests\UserLoginRequest;
use App\Http\Resources\User as UserResource;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    
    public function register(UserRegisterRequest $request){

        return 
        $user = User::create([
            'email' => $request->email,
            'name' => $request->name,
            'password' => bcrypt($request->password),
        ]);

        if(!$token = auth()->attempt($request->only(['email', 'password']))){
            return abort(401);
        }

        return (new UserResource($request->user()))->additional([
            'meta' => [
                'token' => $token,
            ]
        ]);
    }

    public function login(UserLoginRequest $request){

        if(!$token = auth()->attempt($request->only(['email', 'password']))){
            return response()->json([
                'errors' => [
                    'email' => ['Sorry we cannot fine you with those details.']
                ]
            ], 422);
        }

        return (new UserResource($request->user()))->additional([
            'meta' => [
                'token' => $token,
            ]
        ]);
    }

    public function user(Request $request){
        return new UserResource($request->user());
    }

    public function logout(){
        auth()->logout();
    }
}
