<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Tasks\StoreRequest;
use App\Http\Resources\TaskResource;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use App\UseCases\Tasks\DestroyUseCase;
use App\UseCases\Tasks\ListUseCase;
use App\UseCases\Tasks\StoreUseCase;
use App\UseCases\Tasks\UpdateUseCase;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TasksController extends Controller
{
    public function index(Project $project, Request $request): JsonResponse
    {
        return (new ListUseCase(
            filter_project_id: $project->id,
            filter_user_id: (int)$request->input('filter_user_id'),
            filter_status: $request->input('filter_status'),
            page: (int)$request->input('page', 1),
            per_page: (int)$request->input('per_page', 10)
        ))->handle()->responseToApi(true, TaskResource::class);
    }

    public function store(Project $project, StoreRequest $request): JsonResponse
    {
        return (new StoreUseCase(
            project: $project,
            user: User::findOrFail($request->input('user_id')),
            name: $request->input('nombre'),
            status: $request->input('status'),
            description: $request->input('descripcion', null)
        ))->handle()->responseToApi(true, TaskResource::class);
    }

    public function update(Project $project, Task $task, Request $request): JsonResponse
    {
        $this->validateUrl($project, $task);
        
        return (new UpdateUseCase(
            task: $task,
            project: $project,
            user: User::findOrFail($request->input('user_id')),
            name: $request->input('nombre'),
            status: $request->input('status'),
            description: $request->input('descripcion', null)
        ))->handle()->responseToApi(true, TaskResource::class);
    }

    public function destroy(Project $project, Task $task): JsonResponse
    {
        $this->validateUrl($project, $task);

        return (new DestroyUseCase($task))->handle()->responseToApi(true);
    }

    protected function validateUrl(Project $project, Task $task): void
    {
        abort_if($task->project_id !== $project->id, Response::HTTP_NOT_FOUND, 'Task not found in this project');
    }
}
