<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post("login", ['App\Http\Controllers\Api\UserController','login']);
Route::post("register", ['App\Http\Controllers\Api\UserController','register']);

Route::apiResource('posts', 'App\Http\Controllers\Api\PostController');
Route::get('paginate', ['App\Http\Controllers\Api\PostController', 'paginate']);
Route::apiResource('files', 'App\Http\Controllers\Api\FileController');