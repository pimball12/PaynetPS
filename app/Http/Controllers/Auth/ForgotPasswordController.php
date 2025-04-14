<?php

namespace App\Http\Controllers\Auth;

use App\Events\ForgotPasswordRequested;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ForgotPasswordRequest;
use Illuminate\Support\Facades\Password;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class ForgotPasswordController extends Controller
{
    public function sendResetLinkEmail(ForgotPasswordRequest $request): JsonResponse
    {
        event(new ForgotPasswordRequested($request->input('email')));

        return response()->json([

            'message' => 'Link de redefinição enviado para o e-mail'
        ]);
    }
}
