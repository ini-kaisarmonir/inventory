<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ReportController;

Route::get('/', function () {
    return view('frontend.home');
})->name('home');

Route::get('/login', [LoginController::class, 'show'])->name('login');
Route::get('/logout', [LoginController::class, 'logout'])->middleware('auth')->name('logout');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth:web');
Route::resource('products', ProductController::class)->middleware('auth:web');
Route::resource('sales', SaleController::class)->middleware('auth:web');
Route::get('/report', [ReportController::class, 'index'])->middleware('auth:web')->name('report');

Route::get('/dashboard', function () {
    return view('admin.dashboard');
})->name('dashboard')->middleware('auth');
