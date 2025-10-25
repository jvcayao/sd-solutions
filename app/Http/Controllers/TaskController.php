<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $query = Task::with('project');
        if (! $user->roles()->where('name', 'Admin')->exists()) {
            $query->whereHas('project', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            });
        }
        $tasks = $query->latest()->get();

        return TaskResource::collection($tasks);
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
    public function store(StoreTaskRequest $request)
    {
        $data = $request->validated();
        $task = Task::create($data);

        return new TaskResource($task->load('project'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        $this->authorizeTask($task);

        return new TaskResource($task->load('project'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskRequest $request, Task $task)
    {
        $this->authorizeTask($task);
        $task->update($request->validated());

        return new TaskResource($task->load('project'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        $this->authorizeTask($task);
        $task->delete();

        return response()->noContent();
    }

    private function authorizeTask(Task $task)
    {
        $user = Auth::user();
        if ($user->roles()->where('name', 'Admin')->exists()) {
            return;
        }
        if ($task->project->user_id !== $user->id) {
            abort(403, 'Unauthorized.');
        }
    }
}
