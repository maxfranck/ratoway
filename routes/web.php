<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ApportionmentController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
require __DIR__ . '/auth.php';
Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// admin group routes
Route::prefix('admin')->middleware(['auth', 'isAdmin'])->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin.product.index');
    Route::get('/products', [AdminController::class, 'index'])->name('admin.product.index');
    Route::get('/products/create', [AdminController::class, 'create'])->name('admin.product.create');
    Route::post('/products/store', [AdminController::class, 'store'])->name('admin.product.store');
    Route::get('/products/{id}', [AdminController::class, 'show'])->name('admin.product.show');
    Route::get('/products/edit/{id}', [AdminController::class, 'edit'])->name('admin.product.edit');
    Route::post('/products/update/{id}', [AdminController::class, 'update'])->name('admin.product.update');
    Route::delete('/products/{id}', [AdminController::class, 'destroy'])->name('admin.product.destroy');
});

// Apportionment
Route::prefix('apportionment')->middleware('auth')->group(function () {
    Route::get('/', [ApportionmentController::class, 'index'])->name('apportionment.index');
    Route::post('/select', [ApportionmentController::class, 'select'])->name('apportionment.select');
});
