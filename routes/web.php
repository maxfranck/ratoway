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
Route::middleware('auth')->group(function () {
    Route::get('/', [ApportionmentController::class, 'create'])->name('apportionment.create');
    Route::post('/apportionments', [ApportionmentController::class, 'store'])->name('apportionment.store');
    Route::get('/apportionments/{id}', [ApportionmentController::class, 'show'])->name('apportionment.show');
    Route::delete('/apportionments/{id}', [ApportionmentController::class, 'destroy'])->name('apportionment.destroy');

    Route::post('/apportionments/{id}/products', [ApportionmentController::class, 'storeProduct'])->name('apportionment.product.store');
    Route::delete('/apportionments/{apportionment}/products/{product}', [ApportionmentController::class, 'destroyProduct'])
        ->name('apportionment.product.destroy');

    Route::get('/apportionments/{apportionment}/contributors', [ApportionmentController::class, 'contributors'])
        ->name('apportionment.contributors');
    Route::post('/apportionments/{apportionment}/contributors', [ApportionmentController::class, 'storeContributor'])
        ->name('apportionment.contributors.store');
    Route::delete('/apportionments/{apportionment}/contributors/{contributor}', [ApportionmentController::class, 'destroyContributor'])
        ->name('apportionment.contributors.destroy');

    Route::get('/apportionments/{apportionment}/summary', [ApportionmentController::class, 'showSummary'])
        ->name('apportionment.summary');
    Route::post('/apportionments/{apportionment}/abater', [ApportionmentController::class, 'abater'])
        ->name('apportionment.abater');

    Route::get('/apportionment/final/{apportionmentId}', [ApportionmentController::class, 'final'])->name('apportionment.final');
    Route::post('/contributor/pago/{contributor}', [ApportionmentController::class, 'markAsPaid'])->name('contributor.pago')->middleware('web');
});
