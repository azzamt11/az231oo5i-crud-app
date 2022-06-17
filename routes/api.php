<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\SubPostController;

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
Route::get('/userposts', [PostController::class, 'userPost']);
Route::get('/posts', [PostController::class, 'index']);
Route::get('/posts/{id}', [PostController::class, 'showPostById']);
Route::post('/posts/atribute/{id}', [PostController::class, 'addAtribute']);
Route::put('/userposts/{id}', [PostController::class, 'updatePost']);
Route::delete('/userposts/delete/{id}', [PostController::class, 'deletePost']);

//subposts out of middleware
Route::get('/posts/{id}/subposts', [SubPostController::class, 'subindex']);
Route::get('/posts/{id}/subposts/{sid}', [SubPostController::class, 'showSubPostById']);
Route::get('/usersubposts', [SubPostController::class, 'userSubPost']);
Route::put('/posts/{id}/subposts/atribute/{sid}', [SubPostController::class, 'addAtribute']);
Route::post('/posts/{id}/subposts', [SubPostController::class, 'storeSubPost']);
Route::put('/posts/{id}/subposts/{sid}', [SubPostController::class, 'updateSubPost']);

//middleware
Route::middleware(['middleware'=> 'auth:sanctum'], function() {

//user
    Route::get('/user', [AuthController::class, 'user']);

//post
    Route::post('/posts', [PostController::class, 'storePost']);

//subpost
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
