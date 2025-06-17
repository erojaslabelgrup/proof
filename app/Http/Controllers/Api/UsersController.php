<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use App\UseCases\Users\UnwatchUseCase;
use App\UseCases\Users\WatchUseCase;
use Illuminate\Http\JsonResponse;

class UsersController extends Controller
{
    public function unwatchProject(User $user, Project $project): JsonResponse
    {
        return (new UnwatchUseCase($user, $project))->handle()->responseToApi();
    }

    public function unwatchTask(User $user, Task $task): JsonResponse
    {
        return (new UnwatchUseCase($user, $task))->handle()->responseToApi();
    }

    public function watchProject(User $user, Project $project): JsonResponse
    {
        return (new WatchUseCase($user, $project))->handle()->responseToApi();
    }

    public function watchTask(User $user, Task $task): JsonResponse
    {
        return (new WatchUseCase($user, $task))->handle()->responseToApi();
    }
}
