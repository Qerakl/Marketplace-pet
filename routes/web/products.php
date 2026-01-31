<?php

use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Роуты товаров
|--------------------------------------------------------------------------
*/

Route::get('/products/{slug}', [ProductController::class, 'show'])->name('products.show');
