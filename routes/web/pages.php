<?php

use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Статические страницы
|--------------------------------------------------------------------------
*/

Route::get('/faq', [PageController::class, 'faq'])->name('faq');
Route::get('/how-it-works', [PageController::class, 'howItWorks'])->name('how-it-works');
Route::get('/categories', [PageController::class, 'categories'])->name('categories');
