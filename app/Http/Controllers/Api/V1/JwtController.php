<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class JwtController extends Controller
{
    public function register(Request $request){

        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        return response()->json([
            'success' => true,
            'message' => 'User created successfully',
            'user' => $user
        ]);

    }

    public function profile(){

        $userData = auth()->user();
        return response()->json([
            'success' => true,
            'data' => $userData
        ]);

    }

    public function login(Request $request){

        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $token = JWTAuth::attempt($request->only('email', 'password'));

        if(!$token){
            return response()->json([
                'success' => false,
                'message' => 'Invalid email or password'
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'User logged in successfully',
            'token' => $token
        ]);

    }

    public function refresh(){

        $newToken = JWTAuth::refresh();
        return response()->json([
            'success' => true,
            'message' => 'Token refreshed successfully',
            'token' => $newToken
        ]);

    }

    public function logout(){

        JWTAuth::invalidate();
        return response()->json([
            'success' => true,
            'message' => 'User logged out successfully'
        ]);

    }
}
