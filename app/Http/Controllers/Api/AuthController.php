<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(),[
        'name' => 'required',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:6'
        ]);

        if($validator->fails())
        {
            return response()->json([
            'message' => 'Invalid field',
            'error' => $validator->errors()
            ], 422);
        }

        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->image = null;
        $user->save();

        $token = $user->createToken('auth')->plainTextToken;

        return response()->json([
        'message' => 'Register Success',
        'token' => $token,
        'user' => [
            'name' => $user->name,
            'email' => $user->email
        ],
        ], 201);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email','password');

        if(Auth::attempt($credentials))
        {
            $user = Auth::user();

            $token = $user->createToken('auth')->plainTextToken;

            return response()->json([
                'message' => 'Login Success',
                'token' => $token,
                'user' => [
                    'name' => $user->name,
                    'email' => $user->email
                ],
            ], 200);
        }else{
            return response()->json([   
            'message' => 'Invalid Email Or Password'
            ], 401);
        }
        
    }

    public function logout(Request $request)
    {
    
        $request->user()->currentAccessToken()->delete();
    
        return response()->json([
            'message' => 'Logout Success'
        ], 200);
    }
    
}
