<?php

use App\Http\Controllers\Api\ProjectsController;
use App\Http\Controllers\Api\TasksController;
use App\Http\Controllers\Api\UsersController;
use App\Http\Middleware\OnlyIsAdmin;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('projects')->middleware(OnlyIsAdmin::class)->name('projects.')->group(function () {
        Route::apiResource('projects',  ProjectsController::class)->except(['show']);
        Route::apiResource('{project}/tasks', TasksController::class);
    });

    // Watchers
    Route::post('users/{user}/projects/{project}', [UsersController::class, 'watchProject'])->name('users.watch.project');
    Route::post('users/{user}/projects/{task}', [UsersController::class, 'watchTask'])->name('users.watch.task');
    Route::delete('users/{user}/projects/{project}', [UsersController::class, 'unwatchProject'])->name('users.unwatch.project');
    Route::delete('users/{user}/projects/{task}', [UsersController::class, 'unwatchTask'])->name('users.unwatch.task');
});
