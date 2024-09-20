<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;


class AuthController extends Controller
{
    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'max:255'],
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required', 'min:8']
        ]);

        User::create($data);
    }
    public function login(Request $request)
    {
        return 'login';
    }
    public function logout(Request $request)
    {
        return 'logout';
    }


}
