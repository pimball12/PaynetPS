<?php

namespace App\Http\Controllers\Auth;

use App\Events\ForgotPasswordRequested;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ForgotPasswordRequest;
use App\Models\User;
use Illuminate\Support\Facades\Password;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class ForgotPasswordController extends Controller
{
    public function sendResetLinkEmail(ForgotPasswordRequest $request): JsonResponse
    {
        $email = $request->input('email');

        if (User::where('email', $email)->count())     {

            event(new ForgotPasswordRequested($email));
        }

        return response()->json([

            'message' => 'Link de redefinição solicitado para o e-mail. Confira sua caixa de entrada.'
        ]);
    }
}
