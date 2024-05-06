<?php

use App\Http\Controllers\Api\V1\JwtController;
use App\Http\Controllers\Api\V1\TaskController;
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

Route::post('register', [JwtController::class, 'register']);

Route::post('login', [JwtController::class, 'login']);

Route::group(['middleware' => 'auth:api'], function () {

    Route::post('logout', [JwtController::class, 'logout']);
    Route::get('profile', [JwtController::class, 'profile']);
    Route::post('refresh', [JwtController::class, 'refresh']);

});

Route::prefix('v1')->group(function () {
    Route::apiResource('tasks', TaskController::class);
    Route::patch('tasks/{task}/complete', [TaskController::class, 'complete']);
})->middleware('auth:api');

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});



