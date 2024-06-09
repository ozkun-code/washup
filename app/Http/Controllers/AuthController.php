<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginUserRequest;
use App\Models\User;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class AuthController extends Controller
{
    use HttpResponses;


  
    public function login(LoginUserRequest $request)
    {
        if(!Auth::attempt($request->only(['email', 'password']))) {
            return $this->error('', 'Credentials do not match', 401);
        }

        $user = User::where('email', $request->email)->first();

        return $this->success([
            'token' => $user->createToken('API Token')->plainTextToken,
            
        ]);
    }



    public function logout(Request $request) {
        $request->user()->currentAccessToken()->delete();

        return response()->json('Logged out successfully', 200);
    }

}


