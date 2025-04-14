<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use App\Services\Cep\CepServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function __construct(

        private CepServiceInterface $cepService
    ) {}

    public function register(RegisterRequest $request): JsonResponse
    {
        try {

            $cepData = $this->cepService->buscar($request->zip_code);

            $user = User::create([

                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'street' => $request->street,
                'neighborhood' => $request->neighborhood,
                'number' => $request->number,
                'city' => $cepData['localidade'],
                'state' => $cepData['uf'],
                'zip_code' => $request->zip_code,
            ]);

            Auth::attempt($request->only('email', 'password'));
            $request->session()->regenerate();

            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([

                'access_token' => $token,
                'token_type' => 'Bearer',
            ]);
        } catch (\App\Exceptions\CepServiceException $e) {

            return response()->json(['error' => $e->getMessage()], 400);
        } catch (\Exception $e) {

            return response()->json(['error' => 'Erro ao cadastrar usuário: ' . $e->getMessage()], 500);
        }
    }
}
