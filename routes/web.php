<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ArticleController;

Route::get('/categories', [CategoryController::class, 'index']);
Route::apiResource('articles', ArticleController::class);

Route::get('/', function () {
    return view('welcome');
});
