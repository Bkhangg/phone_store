<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Clients\HomeController;
use App\Models\ProductImage;
use Illuminate\Support\Facades\Route;

// Các route cho trang chủ
Route::get('/', [HomeController::class,'index']);

// Các route cho người dùng
require __DIR__.'/admin.php';

// Các route cho console
require __DIR__.'/auth.php';
