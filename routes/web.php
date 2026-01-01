<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Staff\DashboardController as StaffDashboardController;
use App\Http\Controllers\Staff\ProductController as StaffProductController;
use App\Http\Controllers\Staff\OrderController as StaffOrderController;
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

// Public Product Routes
Route::get('/products', [App\Http\Controllers\ProductController::class, 'index'])->name('products.index');
Route::get('/products/{slug}', [App\Http\Controllers\ProductController::class, 'show'])->name('products.show');

// Cart Routes
Route::get('/cart', [App\Http\Controllers\CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [App\Http\Controllers\CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update', [App\Http\Controllers\CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/remove/{productId}', [App\Http\Controllers\CartController::class, 'remove'])->name('cart.remove');
Route::delete('/cart/clear', [App\Http\Controllers\CartController::class, 'clear'])->name('cart.clear');
Route::get('/cart/count', [App\Http\Controllers\CartController::class, 'count'])->name('cart.count');

// Checkout Routes (Auth Required)
Route::middleware('auth')->group(function () {
    Route::get('/checkout', [App\Http\Controllers\CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout/process', [App\Http\Controllers\CheckoutController::class, 'process'])->name('checkout.process');
    
    // Order Routes
    Route::get('/orders', [App\Http\Controllers\OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [App\Http\Controllers\OrderController::class, 'show'])->name('orders.show');
    Route::post('/orders/{order}/cancel', [App\Http\Controllers\OrderController::class, 'cancel'])->name('orders.cancel');
});

// ==========================================
// AUTHENTICATION ROUTES
// ==========================================

Route::middleware('guest')->group(function () {
    // Login
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);

    // Register
    Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
});

// Logout - MUST be POST and authenticated
Route::post('/logout', [LoginController::class, 'logout'])
    ->name('logout')
    ->middleware('auth');

// Home redirect after login
Route::get('/home', function () {
    $user = auth()->user();
    
    if ($user->isAdmin()) {
        return redirect()->route('admin.dashboard');
    }
    
    if ($user->isStaff()) {
        return redirect()->route('staff.dashboard');
    }
    
    return redirect()->route('user.dashboard');
})->middleware('auth')->name('home.redirect');

// ==========================================
// ADMIN ROUTES (Super User - Full Access)
// ==========================================

// ==========================================
// ADMIN ROUTES (Super User - Full Access)
// ==========================================

Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'admin'])
    ->group(function () {
        
        // Dashboard Admin
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])
            ->name('dashboard');
        
        // Categories CRUD (ADMIN ONLY)
        Route::resource('categories', CategoryController::class);
        
        // Products CRUD (ADMIN ONLY - Full Control)
        Route::resource('products', AdminProductController::class);
        
        // Delete product image
        Route::delete('/products/images/{image}', [AdminProductController::class, 'deleteImage'])
            ->name('products.images.delete');
        
        // Users Management (ADMIN ONLY)
        Route::resource('users', UserController::class);
        
        // 🔥 TAMBAHKAN INI - Order Management (ADMIN)
        Route::prefix('orders')->name('orders.')->group(function () {
            Route::get('/', [App\Http\Controllers\Admin\OrderController::class, 'index'])->name('index');
            Route::get('/{order}', [App\Http\Controllers\Admin\OrderController::class, 'show'])->name('show');
            Route::patch('/{order}/status', [App\Http\Controllers\Admin\OrderController::class, 'updateStatus'])->name('updateStatus');
            Route::patch('/{order}/payment', [App\Http\Controllers\Admin\OrderController::class, 'updatePayment'])->name('updatePayment');
        });
        
        // Activity Logs (ADMIN ONLY)
        Route::get('/activity-logs', [AdminDashboardController::class, 'activityLogs'])
            ->name('activity-logs');
        
        // Reports (ADMIN ONLY - Full Access)
        Route::prefix('reports')->name('reports.')->group(function () {
            Route::get('/sales', [AdminDashboardController::class, 'salesReport'])->name('sales');
            Route::get('/products', [AdminDashboardController::class, 'productsReport'])->name('products');
            Route::get('/users', [AdminDashboardController::class, 'usersReport'])->name('users');
            Route::get('/activities', [AdminDashboardController::class, 'activitiesReport'])->name('activities');
        });
        
        // Settings (ADMIN ONLY)
        Route::prefix('settings')->name('settings.')->group(function () {
            Route::get('/', [AdminDashboardController::class, 'settings'])->name('index');
            Route::post('/', [AdminDashboardController::class, 'updateSettings'])->name('update');
        });
    });

// ==========================================
// STAFF ROUTES (Operator - Limited Access)
// ==========================================

Route::prefix('staff')
    ->name('staff.')
    ->middleware(['auth', 'staff'])
    ->group(function () {
        
        // Dashboard Staff
        Route::get('/dashboard', [StaffDashboardController::class, 'index'])
            ->name('dashboard');
        
        // Products Management (STAFF - Can Create, Edit, View)
        Route::resource('products', StaffProductController::class)
            ->except(['destroy']); // Staff tidak bisa delete
        
        // Delete product image (Staff bisa delete image)
        Route::delete('/products/images/{image}', [StaffProductController::class, 'deleteImage'])
            ->name('products.images.delete');
        
        //Orders Management (Staff bisa manage orders)
        //Route::prefix('orders', OrderController::class); // Nanti dibuat
         // 🔥 ORDERS - TAMBAHKAN INI
        Route::get('/orders', [App\Http\Controllers\Staff\OrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/{order}', [App\Http\Controllers\Staff\OrderController::class, 'show'])->name('orders.show');
        Route::patch('/orders/{order}/status', [App\Http\Controllers\Staff\OrderController::class, 'updateStatus'])->name('orders.updateStatus');
        
        // Reports (STAFF - View Only, Limited)
        Route::prefix('reports')->name('reports.')->group(function () {
            Route::get('/products', [StaffDashboardController::class, 'productsReport'])->name('products');
            Route::get('/orders', [StaffDashboardController::class, 'ordersReport'])->name('orders');
        });
    });

// ==========================================
// USER ROUTES (Customer)
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
        
        // Orders (Customer)
        // Route::get('/orders', [UserDashboardController::class, 'orders'])->name('orders');
        // Route::get('/orders/{order}', [UserDashboardController::class, 'orderDetail'])->name('orders.show');
    });
    

// ==========================================
// REDIRECT SETELAH LOGIN (Berdasarkan Role)
// ==========================================

Route::get('/home', function () {
    $user = auth()->user();
    
    if ($user->isAdmin()) {
        return redirect()->route('admin.dashboard');
    }
    
    if ($user->isStaff()) {
        return redirect()->route('staff.dashboard');
    }
    
    return redirect()->route('user.dashboard');
})->middleware('auth')->name('home.redirect');