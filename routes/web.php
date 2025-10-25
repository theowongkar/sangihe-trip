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
});
