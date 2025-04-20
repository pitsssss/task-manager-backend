<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::post('register', [UserController::class, 'register']);
Route::post('login', [UserController::class, 'login']);
Route::post('logout', [UserController::class, 'logout'])->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('tasks')->group(function () {
        Route::get('', [TaskController::class, 'index']);
        Route::post('', [TaskController::class, 'store']);
        Route::put('/{id}', [TaskController::class, 'update']);
        Route::get('/{id}', [TaskController::class, 'show']);
        Route::delete('/{id}', [TaskController::class, 'destroy']);
        Route::get('/{id}/user', [TaskController::class, 'getTaskUser']);
        Route::post('/{id}/categories', [TaskController::class, 'addCategoriesToTask']);
        Route::get('/{id}/categories', [TaskController::class, 'getTasksCategories']);
    });

    //Route::apiResource('tasks', TaskController::class);
    //Route::apiResource('profiles', ProfileController::class);

    Route::get('task/ordered', [TaskController::class, 'getTasksByPriority']);

    Route::post('task/{id}/favorites', [TaskController::class, 'addToFavorites']);
    Route::delete('task/{id}/favorites', [TaskController::class, 'removeFromFavorites']);
    Route::get('task/favorites', [TaskController::class, 'getFavoritesTasks']);


    Route::prefix('user')->group(function () {

    Route::get('/{id}/profiles', [UserController::class, 'getProfile']);
    Route::get('/{id}/tasks', [UserController::class, 'getUserTask']);
    Route::get('', [UserController::class,'getUser']);

    });
    Route::get('allUsersWithProfiles', [UserController::class,'getAllUsersWithProfiles']);

    //only admins can get all tasks in DB:
    Route::get('AllTasks', [TaskController::class, 'GetAllTasks'])->middleware('CheckUser');




    Route::prefix('profiles')->group(function () {
        Route::post('', [ProfileController::class, 'store']);
        Route::get('', [ProfileController::class, 'index']);
        Route::get('/{id}', [ProfileController::class, 'show']);
        Route::put('/{id}', [ProfileController::class, 'update']);
    });

    Route::get('categories/{id}/tasks', [TaskController::class, 'getCategoriesTasks']);
    Route::post('category', [CategoryController::class, 'storeCategory']);
});
