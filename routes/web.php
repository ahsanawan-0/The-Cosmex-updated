<?php

use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ImageController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Public\HomeController;
use App\Http\Controllers\Public\CategoryController;
use App\Http\Controllers\Public\PageController;
use App\Http\Controllers\Public\ProductController as PublicProductController;
use App\Http\Controllers\Public\ReviewController;
use App\Http\Controllers\Public\SearchController;
use App\Http\Controllers\SitemapController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/products', [PublicProductController::class, 'index'])->name('products.index');
Route::get('/products/{slug}', [PublicProductController::class, 'show'])->name('products.show');
Route::get('/category/{slug}', [CategoryController::class, 'show'])->name('category.show');
Route::get('/search', [SearchController::class, 'index'])->name('search');
Route::post('/products/{slug}/reviews', [ReviewController::class, 'store'])->name('reviews.store');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::post('/contact', [PageController::class, 'submitContact'])->name('contact.submit');
Route::get('/privacy-policy', [PageController::class, 'privacy'])->name('privacy');
Route::get('/terms-conditions', [PageController::class, 'terms'])->name('terms');
Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function (): void {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/products/import/template', [AdminProductController::class, 'downloadTemplate'])->name('products.import.template');
    Route::get('/products/import', [AdminProductController::class, 'importForm'])->name('products.import');
    Route::post('/products/import', [AdminProductController::class, 'importCsv'])->name('products.import.store');
    Route::get('/products', [AdminProductController::class, 'index'])->name('products.index');
    Route::get('/products/create', [AdminProductController::class, 'create'])->name('products.create');
    Route::post('/products', [AdminProductController::class, 'store'])->name('products.store');
    Route::get('/products/{id}/edit', [AdminProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{id}', [AdminProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{id}', [AdminProductController::class, 'destroy'])->name('products.destroy');
    Route::post('/products/{id}/toggle-status', [AdminProductController::class, 'toggleStatus'])->name('products.toggle-status');

    Route::get('/categories', [AdminCategoryController::class, 'index'])->name('categories.index');
    Route::get('/categories/create', [AdminCategoryController::class, 'create'])->name('categories.create');
    Route::post('/categories', [AdminCategoryController::class, 'store'])->name('categories.store');
    Route::get('/categories/{id}/edit', [AdminCategoryController::class, 'edit'])->name('categories.edit');
    Route::put('/categories/{id}', [AdminCategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{id}', [AdminCategoryController::class, 'destroy'])->name('categories.destroy');



    Route::post('/images/upload', [ImageController::class, 'upload'])->name('images.upload');
    Route::delete('/images/delete', [ImageController::class, 'delete'])->name('images.delete');
});
