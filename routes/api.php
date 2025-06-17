<?php

use App\Http\Controllers\Api\ProjectsController;
use App\Http\Controllers\Api\TareasController;
use App\Http\Controllers\Api\UsersController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    // Projects
    Route::get('proyectos', [ProjectsController::class, 'index'])->name('projects.index');
    Route::post('proyectos', [ProjectsController::class, 'store'])->name('projects.store');
    Route::put('proyectos/{id}', [ProjectsController::class, 'update'])->name('projects.update');
    Route::delete('proyectos/{id}', [ProjectsController::class, 'destroy'])->name('projects.destroy');

    // Tasks
    Route::get('proyectos/{project}/tasks', [TareasController::class, 'index'])->name('projects.tasks.index');
    Route::post('proyectos/{project}/tasks', [TareasController::class, 'store'])->name('projects.tasks.store');
    Route::put('proyectos/{project}/tasks/{task}', [TareasController::class, 'update'])->name('projects.tasks.update');
    Route::delete('proyectos/{project}/tasks/{task}', [TareasController::class, 'destroy'])->name('projects.tasks.destroy');
    Route::get('proyectos/{project}/tasks/{task}', [TareasController::class, 'show'])->name('projects.tasks.show');

    // Watchers
    Route::post('users/{user}/projects/{project}', [UsersController::class, 'watchProject'])->name('users.watch.project');
    Route::post('users/{user}/projects/{task}', [UsersController::class, 'watchTask'])->name('users.watch.task');
    Route::delete('users/{user}/projects/{project}', [UsersController::class, 'unwatchProject'])->name('users.unwatch.project');
    Route::delete('users/{user}/projects/{task}', [UsersController::class, 'unwatchTask'])->name('users.unwatch.task');
});
