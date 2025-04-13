<?php

namespace App\Providers;

use App\Services\Cep\CepService;
use Illuminate\Support\ServiceProvider;
use App\Services\Cep\CepServiceInterface;

class CepServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(CepServiceInterface::class, CepService::class);
    }
}
