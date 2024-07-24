<?php
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;

Route::get('/', function () {
    return view('welcome');
});

Route::controller(ProductController::class)
->prefix('products') // URL prefix
->name('products.') // route name prefix
->group(function() {
Route::get('', 'list')->name('list');
});

Route::controller(CategoryController::class)
->prefix('categories') // URL prefix
->name('categories.') // route name prefix
->group(function() {
Route::get('', 'list')->name('list');
});
Route::get('/categories/{category}', [CategoryController::class, 'view'])->name('categories.view');
