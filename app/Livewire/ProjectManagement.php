<?php

namespace App\Livewire;


use App\Models\Project;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ProjectManagement extends Component
{
    public $projects;

    public $title;

    public $description;

    public $deadline;

    public $projectId;

    public $isEdit = false;

    protected $rules = [
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'deadline' => 'nullable|date',
    ];

    public function mount()
    {
        $this->fetchProjects();
    }

    public function fetchProjects()
    {
        $user = Auth::user();
        $query = Project::query();
        if (! $user->hasRole('Admin')) {
            $query->where('user_id', $user->id);
        }
        $this->projects = $query->with('tasks')->latest()->get();
    }

    public function resetForm()
    {
        $this->title = $this->description = $this->deadline = $this->projectId = null;
        $this->isEdit = false;
    }

    public function create()
    {
        $this->validate();
        Project::create([
            'user_id' => Auth::id(),
            'title' => $this->title,
            'description' => $this->description,
            'deadline' => $this->deadline,
        ]);
        $this->resetForm();
        $this->fetchProjects();
        session()->flash('success', 'Project created!');
    }

    public function edit($id)
    {
        $project = Project::findOrFail($id);
        $this->projectId = $project->id;
        $this->title = $project->title;
        $this->description = $project->description;
        $this->deadline = $project->deadline;
        $this->isEdit = true;
    }

    public function update()
    {
        $this->validate();
        $project = Project::findOrFail($this->projectId);
        $project->update([
            'title' => $this->title,
            'description' => $this->description,
            'deadline' => $this->deadline,
        ]);
        $this->resetForm();
        $this->fetchProjects();
        session()->flash('success', 'Project updated!');
    }

    public function delete($id)
    {
        Project::findOrFail($id)->delete();
        $this->fetchProjects();
        session()->flash('success', 'Project deleted!');
    }

    public function render()
    {
        return view('livewire.project-management');
    }
}
