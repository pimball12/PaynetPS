<?php

namespace App\Listeners;

use App\Events\ForgotPasswordRequested;
use App\Mail\ResetPasswordMail;
use App\Models\User;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendResetPasswordLink
{
    public function handle(ForgotPasswordRequested $event): void
    {
        $email = $event->email;
        $user = User::where('email', $email)->first();

        if ($user)  {

            $token = Password::createToken($user);

            try {

                Mail::to($email)->send(new ResetPasswordMail($token, $email));
                Log::info("Link de redefinição de senha enviado para {$email}");
            } catch (\Exception $e) {

                Log::error("Erro ao enviar link de redefinição para {$email}: " . $e->getMessage());
            }
        } else {

            Log::error("Usuário não encontrado para {$email}");
        }
    }
}
