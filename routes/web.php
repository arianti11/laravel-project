<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ==========================================
// GUEST ROUTES (Halaman Publik)
// ==========================================

// Landing Page
Route::get('/', function () {
    return view('index');
})->name('home');

// ==========================================
// AUTHENTICATION ROUTES
// ==========================================

// Login
Route::get('/login', [LoginController::class, 'showLoginForm'])
    ->name('login')
    ->middleware('guest');

Route::post('/login', [LoginController::class, 'login'])
    ->middleware('guest');

// Register
Route::get('/register', [RegisterController::class, 'showRegisterForm'])
    ->name('register')
    ->middleware('guest');

Route::post('/register', [RegisterController::class, 'register'])
    ->middleware('guest');

// Logout
Route::post('/logout', [LoginController::class, 'logout'])
    ->name('logout')
    ->middleware('auth');

// ==========================================
// ADMIN ROUTES (Perlu Login)
// ==========================================

Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth'])
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])
            ->name('dashboard');

        // Categories CRUD
        Route::resource('categories', CategoryController::class);

        // Products CRUD
        Route::resource('products', ProductController::class);

        // Users Management
        Route::resource('users', UserController::class);

        // Di dalam Route::prefix('admin')->group()
        Route::delete('/products/images/{image}', [ProductController::class, 'deleteImage'])
            ->name('admin.products.images.delete');

        // Additional Routes (nanti bisa ditambahkan)
        // Route::get('/reports', [ReportController::class, 'index'])->name('reports');
        // Route::get('/settings', [SettingController::class, 'index'])->name('settings');
    });

// ==========================================
// REDIRECT SETELAH LOGIN
// ==========================================

// Kalau user sudah login dan akses root, redirect ke dashboard
Route::get('/home', function () {
    return redirect()->route('admin.dashboard');
})->middleware('auth');