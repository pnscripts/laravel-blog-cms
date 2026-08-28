<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PostController::class, 'index'])->name('home');
Route::get('/blog/{slug}', [PostController::class, 'show'])->name('posts.show');
Route::get('/category/{slug}', [CategoryController::class, 'show'])->name('categories.show');
