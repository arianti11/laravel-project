<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
// Resource routes for Category, Product, ProductImage, and User
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductImageController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('index');
});

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);


// Dashboard (setelah login)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth');

Route::resource('categories', CategoryController::class);
Route::resource('products', ProductController::class);
Route::resource('product-images', ProductImageController::class);
Route::resource('users', UserController::class);
