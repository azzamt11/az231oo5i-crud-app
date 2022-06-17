<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//user out of middleware
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);
Route::post('/user', [AuthController::class, 'update']);
Route::delete('/user', [AuthController::class, 'delete']);
Route::post('/posts', [PostController::class, 'storePost']);

//posts out of middleware
Route::get('/userpost', [PostController::class, 'userPost']);
Route::get('/posts', [PostController::class, 'index']);
Route::get('/posts/{id}', [PostController::class, 'showPostById']);
Route::post('/posts/atribute/{id}', [PostController::class, 'addAtribute']);
Route::put('/userpost/{id}', [PostController::class, 'updatePost']);
Route::delete('/userpost/delete/{id}', [PostController::class, 'deletePost']);

//middleware
Route::middleware(['middleware'=> 'auth:sanctum'], function() {

//user
    Route::get('/user', [AuthController::class, 'user']);

//post
    Route::post('/posts', [PostController::class, 'storePost']);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
