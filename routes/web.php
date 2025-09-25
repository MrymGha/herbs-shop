<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\CustomerAuthController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CustomerController as AdminCustomerController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;

// -------------------------
// Public routes
// -------------------------
Route::get('/', [ProductController::class, 'index'])->name('home');
Route::get('/products/{slug}', [ProductController::class, 'show'])->name('products.show');

// -------------------------
// Customer authentication
// -------------------------
Route::get('/login', [CustomerAuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [CustomerAuthController::class, 'login'])->name('login.submit');
Route::get('/register', [CustomerAuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [CustomerAuthController::class, 'register'])->name('register.submit');

// -------------------------
// Admin authentication
// -------------------------
Route::get('/admin/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');

// -------------------------
// Customer routes (role:customer)
// -------------------------
Route::middleware(['auth', 'role:customer'])->group(function () {

    // Cart
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
    Route::patch('/cart/update/{product}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/remove/{product}', [CartController::class, 'remove'])->name('cart.remove');
    Route::delete('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');

    // Checkout & Orders
    Route::get('/checkout', [OrderController::class, 'create'])->name('checkout.create');
    Route::post('/checkout', [OrderController::class, 'store'])->name('checkout.store');
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// -------------------------
// Admin routes (role:admin)
// -------------------------
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {

    // Dashboard
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');

    // Customers management
    Route::resource('customers', AdminCustomerController::class)->only(['index', 'destroy']);
    Route::patch('customers/{customer}/block', [AdminCustomerController::class, 'block'])->name('customers.block');

    // Products management
    Route::resource('products', AdminProductController::class);

    // Orders management
    // Route::resource('orders', AdminOrderController::class)->only(['index', 'update', 'destroy']);
    Route::resource('orders', AdminOrderController::class);

    // Admin Profile (optional)
    Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('profile', [ProfileController::class, 'update'])->name('profile.update');
});

// -------------------------
// Logout (shared)
// -------------------------
Route::post('/logout', [CustomerAuthController::class, 'logout'])->name('logout');
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

// -------------------------
// Auth routes (if using default Laravel auth scaffolding)
// -------------------------
require __DIR__.'/auth.php';
// use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\ProfileController;
// use App\Http\Controllers\ProductController;
// use App\Http\Controllers\CartController;
// use App\Http\Controllers\OrderController;
// use App\Http\Controllers\AdminAuthController;
// use App\Http\Controllers\CustomerAuthController;
// use App\Http\Controllers\Admin\AdminController;
// use App\Http\Controllers\Admin\CustomerController;
// //use App\Http\Controllers\Admin\OrderController;
// //use App\Http\Controllers\Admin\ProductController;

// // -------------------------
// // Public routes
// // -------------------------
// Route::get('/', [ProductController::class, 'index'])->name('home');
// Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');

// // -------------------------
// // Customer authentication
// // -------------------------
// Route::get('/login', [CustomerAuthController::class, 'showLoginForm'])->name('login');
// Route::post('/login', [CustomerAuthController::class, 'login'])->name('login.submit');
// Route::get('/register', [CustomerAuthController::class, 'showRegisterForm'])->name('register');
// Route::post('/register', [CustomerAuthController::class, 'register'])->name('register.submit');

// // -------------------------
// // Admin authentication
// // -------------------------
// Route::get('/admin/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
// Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');

// // -------------------------
// // Customer routes (role:customer)
// // -------------------------
// Route::middleware(['auth', 'role:customer'])->group(function () {

//     // Cart
//     Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
//     Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
//     Route::patch('/cart/update/{product}', [CartController::class, 'update'])->name('cart.update');
//     Route::delete('/cart/remove/{product}', [CartController::class, 'remove'])->name('cart.remove');
//     Route::delete('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');

//     // Checkout & Orders
//     Route::get('/checkout', [OrderController::class, 'create'])->name('checkout.create');
//     Route::post('/checkout', [OrderController::class, 'store'])->name('checkout.store');
//     Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');

//     // Profile
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

// // -------------------------
// // Admin routes (role:admin)
// // -------------------------
// Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {

//      // Dashboard
//     Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
//     // // Manage Products
//     // Route::resource('products', ProductController::class)->except(['index', 'show']);

//     // // Manage Orders
//     // Route::get('orders', [App\Http\Controllers\OrderController::class, 'adminIndex'])->name('orders.index');
//     // Route::patch('orders/{order}/update-status', [App\Http\Controllers\OrderController::class, 'updateStatus'])->name('orders.updateStatus');

//     // //Custemers management
//     // Route::get('customers', [App\Http\Controllers\CustomerController::class, 'index'])->name('customers.index');
//     // Route::delete('customers/{customer}', [App\Http\Controllers\CustomerController::class, 'destroy'])->name('customers.destroy');
//     // Route::patch('customers/{customer}/block', [App\Http\Controllers\CustomerController::class, 'block'])->name('customers.block');
//     Route::resource('customers', CustomerController::class)->only(['index', 'destroy']);
//     Route::resource('products', ProductController::class);
//     Route::resource('orders', OrderController::class)->only(['index', 'update', 'destroy']);

//     // Admin Profile (optional)
//     Route::get('profile', [ProfileController::class, 'edit'])->name('admin.profile.edit');
//     Route::patch('profile', [ProfileController::class, 'update'])->name('admin.profile.update');
// });

// // -------------------------
// // Logout (shared)
// // -------------------------
// Route::post('/logout', [CustomerAuthController::class, 'logout'])->name('logout');
// Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

// // -------------------------
// // Auth routes (if using default Laravel auth scaffolding)
// // -------------------------
// require __DIR__.'/auth.php';



// use App\Http\Controllers\ProfileController;
// use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\ProductController;
// use App\Http\Controllers\CartController;
// use App\Http\Controllers\OrderController;

// // Route::get('/', function () {
// //     return view('welcome');
// // });

// Route::get('/', [ProductController::class, 'index'])->name('home');
// Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');

// // for customers
// Route::middleware(['auth', 'role:customer'])->group(function () {
//     Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
//     Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
//     Route::patch('/cart/update/{product}', [CartController::class, 'update'])->name('cart.update');
//     Route::delete('/cart/remove/{product}', [CartController::class, 'remove'])->name('cart.remove');
//     Route::delete('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');

//     // Checkout & Orders
//     Route::get('/checkout', [OrderController::class, 'create'])->name('checkout.create');
//     Route::post('/checkout', [OrderController::class, 'store'])->name('checkout.store');
//     Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
// });

// // for Admin
// Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
//     Route::resource('products', ProductController::class)->except(['index', 'show']);
//     Route::get('orders', [OrderController::class, 'adminIndex'])->name('admin.orders.index');
// });
// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });



// require __DIR__.'/auth.php';

