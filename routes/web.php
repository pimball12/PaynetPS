<?php

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

Route::get('/home', function () {

    return view('home');
})->name('home');
// })->middleware('auth:sanctum')->name('home');
