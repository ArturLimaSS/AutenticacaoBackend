<?php

namespace App\Http\Controllers\Auth\Api;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        if (!auth()->attempt($credentials))
            abort(401, 'Invalid Credentials');

        $user = auth()->user();
        $token = auth()->user()->createToken("auth_token");
        return response()->json(
            [
                'data' => [
                    'token' => $token->plainTextToken,
                    'user' => encrypt(auth()->user()->id)
                ]
            ]
        );
    }

    public function logout(Request $request)
{
    if (auth()->check()) {
        auth()->user()->currentAccessToken()->delete();
        return response()->json(array('status' => 'success', 'message' => 'Você foi derrubado com sucesso!'));
    } else {
        return response()->json(array('status' => 'error', 'message' => 'Not authenticated'), 401);
    }
}
}