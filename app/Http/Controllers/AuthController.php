<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'max:255'],
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required', 'confirmed', 'min:8']
        ]);

        $user = User::create($data);

        $token = $user->createToken($data['name'])->plainTextToken;

        return [
            'user' => $user,
            'token' => $token
        ];
    }
    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => ['required', 'email', 'exists:users'],
            'password' => ['required']
        ]);

        $user = User::where('email', $data['email'])->first();
        if (!$user || !Hash::check($data['password'], $user->password)) {
            return [
                'message' => 'The provided credentials are incorrect.'
            ];
        }
        $token = $user->createToken($user->name)->plainTextToken;
        return [
            'user' => $user,
            'token' => $token
        ];
    }
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return [
            'message' => 'You are logged out'
        ];
    }
}
