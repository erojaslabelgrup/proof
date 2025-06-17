<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Projects\IndexRequest;
use App\Http\Requests\Api\Projects\StoreRequest;
use App\Http\Requests\Api\Projects\UpdateRequest;
use App\Http\Resources\ProjectResource;
use App\Models\Project;
use App\UseCases\Projects\DestroyUseCase;
use App\UseCases\Projects\ListUseCase;
use App\UseCases\Projects\StoreUseCase;
use App\UseCases\Projects\UpdateUseCase;
use Illuminate\Http\JsonResponse;

class ProjectsController extends Controller
{
    public function index(IndexRequest $request): JsonResponse
    {
        return (new ListUseCase(
            page: (int)$request->input('page', 1),
            per_page: (int)$request->input('per_page', 10)
        ))->handle()->responseToApi(true, ProjectResource::class);
    }

    public function store(StoreRequest $request): JsonResponse
    {
        return (new StoreUseCase(
            identifier: $request->input('identifier'),
            name: $request->input('name'),
            status: $request->input('status'),
            description: $request->input('description')
        ))->handle()->responseToApi(true, ProjectResource::class);
    }

    public function update(Project $project, UpdateRequest $request): JsonResponse
    {
        return (new UpdateUseCase(
            project: $project,
            identifier: $request->input('identifier'),
            name: $request->input('name'),
            status: $request->input('status'),
            description: $request->input('description')
        ))->handle()->responseToApi(true, ProjectResource::class);
    }

    public function destroy(Project $project): JsonResponse
    {
        return (new DestroyUseCase($project))->handle()->responseToApi(true);
    }
}
