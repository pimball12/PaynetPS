<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ForgotPasswordRequest;
use Illuminate\Support\Facades\Password;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class ForgotPasswordController extends Controller
{
    public function sendResetLinkEmail(ForgotPasswordRequest $request): JsonResponse
    {
        $response = Password::sendResetLink(

            $request->only('email')
        );

        if ($response === Password::RESET_LINK_SENT) {

            return response()->json([

                'message' => 'Link de redefinição enviado para o e-mail'
            ]);
        }

        return response()->json([

            'message' => 'Não foi possível enviar o link de redefinição'
        ], 500);
    }
}
