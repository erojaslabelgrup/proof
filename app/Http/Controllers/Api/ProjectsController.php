<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectsController extends Controller
{
    public function index()
    {
        return Project::all();
    }

    public function store($request)
    {
        return Project::create($request->all());
    }

    public function update($id, $request)
    {
        $project = Project::where('id', $id)->first();
        $project->update($request->all());

        return response()->json($project->toArray());
    }

    public function destroy($id)
    {
        Project::where('id', $id)->first()->delete();
    }
}
