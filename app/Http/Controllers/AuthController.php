<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name'      => 'required|string',
            'email'     => 'required|string|email|unique:users',
            'password'  => 'required|string|confirmed',
        ]);

        $user = new User([
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => bcrypt($request->password),
        ]);

        $user->save();

        return response()->json([
            'message' => 'Register Berhasil!'
        ], 201);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'     => 'required|string|email',
            'password'  => 'required|string',
        ]);

        $credentials = request(['email', 'password']);

        if(!Auth::attempt($credentials))
        {
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        }

        $user = $request->user();

        $tokenResult = $user->createToken('MyTransaction');
        $token = $tokenResult->token;

        $token->save();

        return response()->json([
            'token' => $tokenResult->accessToken,
            'token_type'=> 'Bearer',
            'message' => 'Login Berhasil!'
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();

        return response()->json([
            'message' => 'Logout Berhasil!'
        ]);
    }

    public function user(Request $request)
    {
        return response()->json($request->user());
    }
}
