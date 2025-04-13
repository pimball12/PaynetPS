<?php

use App\Http\Controllers\Auth\ResetPasswordController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {

    return view('auth.login');
})->name('login');

Route::get('/register', function () {

    return view('auth.register');
})->name('register');

Route::get('/forgot-password', function () {

    return view('auth.forgot-password');
})->name('password.request');

Route::get('/reset-password/{token}', function (string $token) {
    return view('auth.reset-password', ['token' => $token]);
})->name('password.reset');

Route::post('/reset-password', [ResetPasswordController::class, 'reset'])
    ->name('password.update');

Route::get('/home', function () {

    return view('home');
})->name('home');
