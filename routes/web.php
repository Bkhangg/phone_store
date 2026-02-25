<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\ProfileController;
use App\Models\ProductImage;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Dashboard và các route quản trị viên
Route::middleware(['auth', 'verified', 'admin', 'check.status'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::resource('categories', CategoryController::class);
    Route::get('/admin/categories/toggle-status/{id}', [CategoryController::class, 'toggleStatus'])
    ->name('categories.toggleStatus');

    Route::resource('products', ProductController::class);
    Route::get('/admin/products/toggle-status/{id}', [ProductController::class, 'toggleStatus'])
    ->name('products.toggleStatus');

    Route::resource('users', UserController::class);

    Route::prefix('admin')->middleware(['auth','admin'])->group(function () {
        Route::post('/users/{id}/ban', [UserController::class,'ban'])->name('users.ban');
        Route::post('/users/{id}/unban', [UserController::class,'unban'])->name('users.unban');
    });

    Route::delete('product-images/{id}',
        [ProductController::class,'destroyImage']
    )->name('product-images.destroy');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



require __DIR__.'/auth.php';
