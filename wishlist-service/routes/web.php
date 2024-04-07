<?php

use App\Http\Controllers\WishListController;
use Illuminate\Support\Facades\Route;

Route::post('/wishlist', [WishListController::class, 'create']);
Route::put('/wishlist/{id}', [WishListController::class, 'update']);
Route::get('/wishlist/{userId}', [WishListController::class, 'getList']);
Route::delete('/wishlist/{id}/{userId}', [WishListController::class, 'delete']);
Route::get('/wishlist/{id}', [WishListController::class, 'get']);
