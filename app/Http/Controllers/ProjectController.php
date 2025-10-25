<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Http\Resources\ProjectResource;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $query = Project::with('tasks');
        if (! $user->roles()->where('name', 'Admin')->exists()) {
            $query->where('user_id', $user->id);
        }
        $projects = $query->latest()->get();

        return ProjectResource::collection($projects);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProjectRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = Auth::id();
        $project = Project::create($data);

        return new ProjectResource($project->load('tasks'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        $this->authorizeProject($project);

        return new ProjectResource($project->load('tasks'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProjectRequest $request, Project $project)
    {
        $this->authorizeProject($project);
        $project->update($request->validated());

        return new ProjectResource($project->load('tasks'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        $this->authorizeProject($project);
        if ($project->tasks()->count() > 0) {
            return response()->json(['message' => 'Cannot delete project with existing tasks.'], 409);
        }
        $project->delete();

        return response()->noContent();
    }

    /**
     * Authorize the specified project.
     */
    private function authorizeProject(Project $project)
    {
        $user = Auth::user();
        if (method_exists($user, 'hasRole') && $user->hasRole('Admin')) {
            return;
        }
        if ($project->user_id !== $user->id) {
            abort(403, 'Unauthorized.');
        }
    }
}
