<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AdminLogController;


Route::get('/', [AuthController::class, 'showLogin'])->name('showLogin');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {

    Route::get('/user/home', function () {
        return view('user.home');
    });

    // User profile edit
    Route::get('/user/profile/edit', [AuthController::class, 'editProfile'])->name('user.editProfile');
    Route::post('/user/profile/update', [AuthController::class, 'updateProfile'])->name('user.updateProfile');

    Route::prefix('admin')->middleware('admin')->group(function () {
        // Admin profile edit
        Route::get('/profile/edit', [AuthController::class, 'editProfile'])->name('admin.editProfile');
        Route::post('/profile/update', [AuthController::class, 'updateProfile'])->name('admin.updateProfile');
        Route::get('/dashboard', function () {
            $products = \App\Models\Product::with('category')->get();
            return view('admin.dashboard', compact('products'));
        })->name('admin.dashboard');
        Route::get('/category/select', [ProductController::class, 'selectCategory'])
            ->name('category.select');

        Route::post('/category/select', [ProductController::class, 'storeCategorySelection'])
            ->name('category.storeSelection');

        // Step 2
        Route::get('/product/create', [ProductController::class, 'create'])
            ->name('product.create');

        Route::post('/product/store', [ProductController::class, 'store'])
            ->name('product.store');

        // List all products with category name
        Route::get('/products', [ProductController::class, 'index'])
            ->name('product.index');

        // Edit and Delete product
        Route::get('/product/{product}/edit', [ProductController::class, 'edit'])->name('product.edit');
        Route::put('/product/{product}', [ProductController::class, 'update'])->name('product.update');
        Route::delete('/product/{product}', [ProductController::class, 'destroy'])->name('product.destroy');

        //logs 
        Route::get('/admin-logs',[AdminLogController::class,'index'])->name('admin.logs');
        Route::get('/user-logs',[App\Http\Controllers\UserLogController::class,'index'])->name('user.logs');
        Route::get('/category-logs',[App\Http\Controllers\CategoryLogController::class,'index'])->name('category.logs');
    });
});
