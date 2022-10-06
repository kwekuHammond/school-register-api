<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\Api\UsersController;
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

Route::post('users', [AuthController::class, 'register']);



//search route
// Route::middleware('auth:sanctum')->get('users/search/{userName}', [UsersController::class, 'search']);

//Routes we want to protect goes here
Route::group(['middleware'=>['auth:sanctum']], function(){
    Route::get('users/search/{userName}', [UsersController::class, 'search']);
    Route::get('users/{id}', [UsersController::class, 'show']);
    Route::delete('users/{id}', [UsersController::class, 'destroy']);
    Route::get('users', [UsersController::class, 'index']);
});
