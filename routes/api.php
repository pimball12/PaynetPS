<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\CepController;
use App\Http\Controllers\HomeController;
use App\Services\Cep\CepServiceInterface;

Route::post('/register', [RegisterController::class, 'register']);
Route::post('/login', [LoginController::class, 'login']);
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail']);

Route::middleware('auth:sanctum')->group(function () {

    Route::get('/home', [HomeController::class, 'index']);
});

Route::get('/cep/{cep}', [CepController::class, 'buscarCep']);
