<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;

class ForgotPasswordRequested
{
    use SerializesModels;

    public string $email;

    public function __construct(string $email)
    {
        $this->email = $email;
    }
}
