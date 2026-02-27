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
Route::middleware(['auth', 'verified', 'check.status'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', function () {
            return view('dashboard');
        })->name('dashboard');

        // Các route cho danh mục
        Route::resource('categories', CategoryController::class);
        Route::get('categories/toggle-status/{id}',
            [CategoryController::class, 'toggleStatus']
        )->name('categories.toggleStatus');

        // Các route cho sản phẩm
        Route::resource('products', ProductController::class);
        Route::get('products/toggle-status/{id}',
            [ProductController::class, 'toggleStatus']
        )->name('products.toggleStatus');

        // Route cho xóa ảnh sản phẩm
        Route::delete('product-images/{id}',
            [ProductController::class,'destroyImage']
        )->name('product-images.destroy');

        // Thêm route cho soft delete
        Route::get('products-trash', [ProductController::class,'trash'])->name('products.trash');
        Route::post('products-restore/{id}', [ProductController::class,'restore'])->name('products.restore');
        Route::delete('products-force-delete/{id}', [ProductController::class,'forceDelete'])->name('products.forceDelete');

        // Các route cho người dùng
        Route::resource('users', UserController::class);
        Route::prefix('admin')->middleware(['auth','admin'])->group(function () { Route::post('/users/{id}/ban', [UserController::class,'ban'])->name('users.ban');
        Route::post('/users/{id}/unban', [UserController::class,'unban'])->name('users.unban'); });
});

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



require __DIR__.'/auth.php';
