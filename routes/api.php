<?php

use App\Http\Controllers\Api\Task;
use App\Http\Controllers\Api\TaskController;
use App\Http\Controllers\Api\UserAuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


// crud tasks
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('tasks',TaskController::class);
 });

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
// authentification part
Route::post('register',[UserAuthController::class,'register']);
Route::post('login',[UserAuthController::class,'login']);
Route::post('logout',[UserAuthController::class,'logout'])
  ->middleware('auth:sanctum');