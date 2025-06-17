<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Projects\IndexRequest;
use App\Http\Requests\Api\Projects\StoreRequest;
use App\Http\Resources\ProjectResource;
use App\Models\Project;
use App\UseCases\Projects\ListUseCase;
use App\UseCases\Projects\StoreUseCase;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

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
            description: $request->input('description', null)
        ))->handle()->responseToApi(true, ProjectResource::class);
    }

    public function update($id, $request): JsonResponse
    {
        $project = Project::where('id', $id)->first();
        $project->update($request->all());

        return response()->json($project->toArray());
    }

    public function destroy(Project $project): JsonResponse
    {
        $project->delete();

        return response()->json(['message' => 'Project deleted successfully'], Response::HTTP_NO_CONTENT);
    }
}
