<?php

namespace App\Http\Controllers\Auth\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class RegisterController extends Controller
{
    public function register(Request $request, User $user)
    {
        $userData = $request->only('name', 'email', 'password');
        $userData['password'] = bcrypt($userData['password']);
        if (!$user->create($userData))
            abort(500, 'Error to create a new user...');

        return response()->json(array("status" => "success", "message" => "User Created Successfully"));
    }
}