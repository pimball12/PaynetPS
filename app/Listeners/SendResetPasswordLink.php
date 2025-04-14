<?php

namespace App\Listeners;

use App\Events\ForgotPasswordRequested;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Log;

class SendResetPasswordLink
{
    public function handle(ForgotPasswordRequested $event): void
    {
        $response = Password::sendResetLink(['email' => $event->email]);

        if ($response === Password::RESET_LINK_SENT) {

            Log::info("Link de redefinição de senha enviado para {$event->email}");
        } else {

            Log::error("Erro ao enviar link de redefinição para {$event->email}");
        }
    }
}
