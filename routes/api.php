<?php

use App\Http\Controllers\Auth\AuthenticationController;
use App\Http\Controllers\FeedController;
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

Route::post('feeds/store', [FeedController::class, 'store'])->middleware('auth:sanctum');
Route::post('feeds/like/{feed_id}', [FeedController::class, 'likePost'])->middleware('auth:sanctum');
Route::get('feeds', [FeedController::class, 'index'])->middleware('auth:sanctum');
Route::post('feeds/comment/{feed_id}', [FeedController::class, 'comment'])->middleware('auth:sanctum');
Route::get('feeds/comments/{feed_id}', [FeedController::class, 'getComments'])->middleware('auth:sanctum');

Route::get('/get', function () {
    return response([
        'message'   =>  'cool',
    ], 200);
});

Route::post('register', [AuthenticationController::class, 'register']);
Route::post('login', [AuthenticationController::class, 'login']);
//Route::post('/feeds/store', [FeedController::class, 'store']);
