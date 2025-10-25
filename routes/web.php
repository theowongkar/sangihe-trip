<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ProfileController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ProductReviewController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\UserController as DashboardUserController;
use App\Http\Controllers\Dashboard\ProductCategoryController as DashboardProductCategoryController;

// Home
Route::get('/', [HomeController::class, 'index'])->name('home');

// Produk
Route::get('/produk', [ProductController::class, 'index'])->name('product.index');
Route::get('/produk/{slug}', [ProductController::class, 'show'])->name('product.show');

// Artikel
Route::get('/artikel', [ArticleController::class, 'index'])->name('article.index');
Route::get('/artikel/{slug}', [ArticleController::class, 'show'])->name('article.show');

Route::middleware('guest')->group(function () {
    // Login
    Route::get('/login', [LoginController::class, 'login'])->name('login');
    Route::post('/login', [LoginController::class, 'authenticate'])->middleware('throttle:10,5');

    // Register
    Route::get('/register', [RegisterController::class, 'register'])->name('register');
    Route::post('/register', [RegisterController::class, 'store'])->middleware('throttle:5,5');
});

Route::middleware('auth', 'isActiveUser')->group(function () {
    // Logout
    Route::post('/logout', [LoginController::class, 'logout'])->middleware('throttle:5,5')->name('logout');

    // Edit Profil
    Route::get('/profil-saya', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profil-saya', [ProfileController::class, 'update'])->middleware('throttle:5,5')->name('profile.update');

    // Review Produk
    Route::post('/review/{product}', [ProductReviewController::class, 'upsert'])->middleware('throttle:5,5')->name('product-review.upsert');
    Route::delete('/review/{product}', [ProductReviewController::class, 'destroy'])->middleware('throttle:5,5')->name('product-review.destroy');
});


Route::middleware('auth', 'isActiveUser', 'isAdmin')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Dashboard User
    Route::get('/dashboard/pengguna', [DashboardUserController::class, 'index'])->name('dashboard.user.index');
    Route::get('/dashboard/pengguna/tambah', [DashboardUserController::class, 'create'])->name('dashboard.user.create');
    Route::post('/dashboard/pengguna/tambah', [DashboardUserController::class, 'store'])->name('dashboard.user.store');
    Route::get('/dashboard/pengguna/{user}/ubah', [DashboardUserController::class, 'edit'])->name('dashboard.user.edit');
    Route::put('/dashboard/pengguna/{user}/ubah', [DashboardUserController::class, 'update'])->name('dashboard.user.update');
    Route::delete('/dashboard/pengguna/{user}/hapus', [DashboardUserController::class, 'destroy'])->name('dashboard.user.destroy');

    // Dashboard Kategori Produk
    Route::get('/dashboard/kategori-produk', [DashboardProductCategoryController::class, 'index'])->name('dashboard.product-category.index');
    Route::post('/dashboard/kategori-produk/tambah', [DashboardProductCategoryController::class, 'store'])->name('dashboard.product-category.store');
    Route::put('/dashboard/kategori-produk/{productCategory:slug}/ubah', [DashboardProductCategoryController::class, 'update'])->name('dashboard.product-category.update');
    Route::delete('/dashboard/kategori-produk/{productCategory:slug}/hapus', [DashboardProductCategoryController::class, 'destroy'])->name('dashboard.product-category.destroy');
});
