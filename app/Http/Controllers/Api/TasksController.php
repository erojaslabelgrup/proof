<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TasksController extends Controller
{
    public function index(Project $project, Request $request): JsonResponse
    {
        $request->validate(['nombre' => 'required|string', 'filter_status' => 'nullable|in:' . implode(',', Project::STATUSES), 'page' => 'sometimes|numeric|min:1', 'per_page' => 'sometimes|numeric|min:1|max:100']);

        $nombre = $request->input('nombre');
        $filterStatus = $request->input('filter_status');
        $page = $request->input('page', 1);
        $perPage = $request->input('per_page', 10);





        $query = Task::where('project_id', $project->id);

        if ( $nombre)  {$query->where('name', 'like', "%$nombre%");}

        if ($filterStatus) {
            $query->where('status', $filterStatus);
        }

        $projects = $query->paginate($perPage, ['*'], 'page', $page);

        return response()->json([
            'data' => $projects->items(),
            'meta' => [
                'current_page' => $projects->currentPage(),
                'last_page' => $projects->lastPage(),
                'per_page' => $projects->perPage(),
                'total' => $projects->total()
            ]
        ]);
    }

    public function store(Project $project, Request $request): JsonResponse
    {
        $request->validate([
        'nombre' => 'required|string|max:255',
        'descripcion' => 'nullable|string',
            'status' => 'required|string'
        ]);

        return response()->json(Task::create([
            'project_id' => $project->id,
            'name' => $request->input('nombre'),
        'description' => $request->input('descripcion'),
        'status' => $request->input('status')
        ]), 200);
    }

    public function update(Project $project, Task $task, Request $request): JsonResponse
    {
        $request->validate([
            'name' => 'sometimes|string|max:255',
        'description' => 'nullable|string',
            'status' => 'sometimes|in:' . implode(',', Project::STATUSES)
        ]);

        $task->update(['name' => $request->input('name', $task->name),
            'description' => $request->input('description', $task->description),
            'status' => $request->input('status', $task->status)
        ]);

        return response()->json($task, 200);
    }

    public function destroy(Project $project, Task $task): JsonResponse
    {
        $task->delete();
          return response()->json(status: Response::HTTP_NO_CONTENT);
    }
}
