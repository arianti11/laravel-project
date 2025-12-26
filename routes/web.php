<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\User\UserDashboardController;

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
    ->name('login');
    // ->middleware('guest');

Route::post('/login', [LoginController::class, 'login']);
    // ->middleware('guest');

// Register
Route::get('/register', [RegisterController::class, 'showRegisterForm'])
    ->name('register');
    // ->middleware('guest');

Route::post('/register', [RegisterController::class, 'register']);
    // ->middleware('guest');

// Logout
Route::post('/logout', [LoginController::class, 'logout'])
    ->name('logout');
    // ->middleware('auth');

// ==========================================
// ADMIN ROUTES (Perlu Login + Role Admin)
// ==========================================

Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'admin'])
    ->group(function () {
        
        // Dashboard Admin
        Route::get('/dashboard', [DashboardController::class, 'index'])
            ->name('dashboard');
        
        // Categories CRUD
        Route::resource('categories', CategoryController::class);
        
        // Products CRUD
        Route::resource('products', ProductController::class);
        
        // Delete product image
        Route::delete('/products/images/{image}', [ProductController::class, 'deleteImage'])
            ->name('products.images.delete');
        
        // Users Management
        Route::resource('users', UserController::class);
    });

// ==========================================
// USER ROUTES (Perlu Login, Role User Biasa)
// ==========================================

Route::prefix('user')
    ->name('user.')
    ->middleware(['auth'])
    ->group(function () {
        
        // Dashboard User
        Route::get('/dashboard', [UserDashboardController::class, 'index'])
            ->name('dashboard');
        
        // Profile
        Route::get('/profile', [UserDashboardController::class, 'profile'])
            ->name('profile');
        
        Route::put('/profile', [UserDashboardController::class, 'updateProfile'])
            ->name('profile.update');
    });

// ==========================================
// REDIRECT SETELAH LOGIN
// ==========================================

Route::get('/home', function () {
    if (auth()->user()->isAdmin()) {
        return redirect()->route('admin.dashboard');
    }
    return redirect()->route('user.dashboard');
})->middleware('auth');