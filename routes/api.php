<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\TodoListController;
use App\Http\Controllers\Api\TaskController;


// Authentication routes
Route::prefix('auth')->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout'])->middleware('jwt.auth');
    Route::get('me', [AuthController::class, 'me'])->middleware('jwt.auth');
});

// Protected routes
Route::middleware('jwt.auth')->group(function () {
    Route::apiResource('todo-lists', TodoListController::class);
    Route::apiResource('todo-lists.tasks', TaskController::class)->shallow();
});