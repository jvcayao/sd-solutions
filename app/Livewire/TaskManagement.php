<?php

namespace App\Livewire;

use App\Models\Project;
use App\Models\Task;
use Livewire\Component;

class TaskManagement extends Component
{
    public $tasks;

    public $projects;

    public $title;

    public $status;

    public $due_date;

    public $project_id;

    public $taskId;

    public $isEdit = false;

    protected $rules = [
        'title' => 'required|string|max:255',
        'status' => 'required|in:todo,in progress,done',
        'due_date' => 'nullable|date',
        'project_id' => 'required|exists:projects,id',
    ];

    public function mount()
    {
        $this->fetchTasks();
        $this->projects = Project::all();
    }

    public function fetchTasks()
    {
        $this->tasks = Task::with('project')->latest()->get();
    }

    public function resetForm()
    {
        $this->title = $this->status = $this->due_date = $this->project_id = $this->taskId = null;
        $this->isEdit = false;
    }

    public function create()
    {
        $this->validate();
        Task::create([
            'project_id' => $this->project_id,
            'title' => $this->title,
            'status' => $this->status,
            'due_date' => $this->due_date,
        ]);
        $this->resetForm();
        $this->fetchTasks();
        session()->flash('success', 'Task created!');
    }

    public function edit($id)
    {
        $task = Task::findOrFail($id);
        $this->taskId = $task->id;
        $this->project_id = $task->project_id;
        $this->title = $task->title;
        $this->status = $task->status;
        $this->due_date = $task->due_date;
        $this->isEdit = true;
    }

    public function update()
    {
        $this->validate();
        $task = Task::findOrFail($this->taskId);
        $task->update([
            'project_id' => $this->project_id,
            'title' => $this->title,
            'status' => $this->status,
            'due_date' => $this->due_date,
        ]);
        $this->resetForm();
        $this->fetchTasks();
        session()->flash('success', 'Task updated!');
    }

    public function delete($id)
    {
        Task::findOrFail($id)->delete();
        $this->fetchTasks();
        session()->flash('success', 'Task deleted!');
    }

    public function render()
    {
        return view('livewire.task-management');
    }
}
