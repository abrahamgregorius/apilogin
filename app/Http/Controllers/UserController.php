<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function register(Request $request) {
        $validator = Validator::make($request->all(), [
            'username' => 'required|unique:users,username',
            'password' => 'required'
        ]);

        if($validator->fails()){
            return response()->json([
                'message' => 'Invalid field',
                'error' => $validator->errors()
            ],422);
        }

        $user = User::create($request->all());
    
        return response()->json([
            'message' => 'User created',
            'user' => $user
        ]);
    }

    public function login(Request $request) {
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required'
        ]);

        if($validator->fails()){
            return response()->json([
                'message' => 'Invalid field',
                'error' => $validator->errors()
            ],422);
        }

        if(!Auth::attempt(['username' => $request->username, 'password' => $request->password])){
            return response()->json([
                'message' => 'Invalid credentials'
            ], 401);
        }

        $token = uuid_create();

        $user = User::find(auth()->user()->id)->update([
            'token' => $token
        ]);

        return response()->json([
            'message' => 'Login successful',
            'username' => auth()->user()->username,
            'token' => $token
        ]);
    }

    public function logout(Request $request) {
        $user = User::where('token', $request->bearerToken())->first();

        if(!$user) {
            return response()->json([
                'message' => 'User not found'
            ], 404);
        }
        
        $user->update([
            'token' => null
        ]);

        return response()->json([
            'message' => 'Logout successful'
        ]);
    }
}
