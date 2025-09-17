<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\JWT;

class AuthController extends Controller
{
    public function register(Request $request) {
        $validated = $request->validate(
            [
                'name'=>'required|string|max:255',
                'email'=>'required|string|email|unique:users',
                'password'=>'required|string|confirmed'
            ]
        );

        $validated['password'] = Hash::make($validated['password']);

        $user = User::create($validated);
        $token = JWTAuth::fromUser($user);
        return response()->json(compact('user', 'token'), 201);
    }

    public function login(Request $request) {
        $credentials = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if (!$token = JWTAuth::attempt($credentials)) {
            return response()->json(['error' => 'Invalid Credentials'], 401);
        }

        $user = JWTAuth::user();
        return response()->json(compact('user', 'token'));
    }

    public function me() {
        return response()->json(Auth::user());
    }

    public function logout() {
        Auth::logout();
        return response()->json(['message'=>'Logged out successfully']);
    }
}
