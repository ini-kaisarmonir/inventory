<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;

Route::get('/', function () {
    return view('frontend.home');
})->name('home');

Route::get('/login', [LoginController::class, 'show'])->name('login');
Route::get('/logout', [LoginController::class, 'logout'])->middleware('auth')->name('logout');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth');

Route::get('/dashboard', function () {
    return view('admin.dashboard');
})->name('dashboard')->middleware('auth');
