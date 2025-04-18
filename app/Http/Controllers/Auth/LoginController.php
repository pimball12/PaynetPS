<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(LoginRequest $request): JsonResponse
    {
        if (!Auth::attempt($request->only('email', 'password'))) {

            return response()->json(['message' => 'Credenciais inválidas'], 401);
        }

        $request->session()->regenerate();

        $token = $request->user()->createToken('auth_token')->plainTextToken;

        return response()->json([

            'access_token' => $token,
            'token_type' => 'Bearer',
            'session_id' => session()->getId(),
            'user' => $request->user()->only('id', 'name', 'email')
        ]);
    }
}
