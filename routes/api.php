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

//middleware
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//first step authentication
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function() {

    //in-middleware user functions
    Route::post('/user', [AuthController::class, 'user']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/user', [AuthController::class, 'update']);
    Route::delete('/user', [AuthController::class, 'delete']);
    Route::post('/posts', [PostController::class, 'storePost']);

    //in-middleware post functions
    Route::get('/posts', [PostController::class, 'index']);
    Route::get('/userposts', [PostController::class, 'userPost']);
    Route::get('/posts/{id}', [PostController::class, 'showPostById']);
    Route::post('/posts/attribute/{id}', [PostController::class, 'addAttribute']);
    Route::put('/posts/{id}', [PostController::class, 'updatePost']);
    Route::delete('/posts/delete/{id}', [PostController::class, 'deletePost']);

    //in-middleware subpost functions
    Route::get('/posts/{id}/subposts', [SubPostController::class, 'subindex']);
    Route::get('/posts/{id}/subposts/{sid}', [SubPostController::class, 'showSubPostById']);
    Route::get('/usersubposts', [SubPostController::class, 'userSubPost']);
    Route::put('/posts/{id}/subposts/attribute/{sid}', [SubPostController::class, 'addAttribute']);
    Route::post('/posts/{id}/subposts', [SubPostController::class, 'storeSubPost']);
    Route::put('/posts/{id}/subposts/{sid}', [SubPostController::class, 'updateSubPost']);
    Route::delete('/posts/{id}/subposts/delete/{sid}', [SubPostController::class, 'deleteSubPost']);

});

