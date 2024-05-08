<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\FriendRequestController;
use App\Http\Controllers\ProfileEditingController;
use App\Http\Controllers\SearchController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('me', [AuthController::class, 'me']);
});

Route::group([

    'middleware' => 'api',
    'prefix' => 'friends'

], function ($router) {
    Route::get('proposals', [FriendRequestController::class, 'proposals']);
    Route::get('requests', [FriendRequestController::class, 'requests']);
    Route::get('list', [FriendRequestController::class, 'list']);
    
    Route::post('send', [FriendRequestController::class, 'send']);
    Route::patch('accept', [FriendRequestController::class, 'accept']);
    Route::patch('reject', [FriendRequestController::class, 'reject']);
        
    Route::delete('delete', [FriendRequestController::class, 'delete']);

});

Route::group([

    'middleware' => 'api',
    'prefix' => 'edit'

], function ($router) {
    Route::patch('name', [ProfileEditingController::class, 'updateName']);
    Route::patch('email', [ProfileEditingController::class, 'updateEmail']);

});

Route::group([

    'middleware' => 'api',
    'prefix' => 'search'

], function ($router) {
    Route::get('by_name', [SearchController::class, 'findByName']);

});