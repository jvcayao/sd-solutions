<div class="max-w-3xl mx-auto p-4">
    <h2 class="text-3xl font-extrabold mb-6 text-green-700 flex items-center gap-2">
        <svg class="w-7 h-7 text-green-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-3-3v6m9 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        Tasks
    </h2>
    @if (session()->has('success'))
        <div class="bg-green-100 text-green-800 p-2 rounded mb-2 shadow">{{ session('success') }}</div>
    @endif
    <form wire:submit.prevent="{{ $isEdit ? 'update' : 'create' }}" class="mb-8 bg-white rounded shadow p-4 space-y-3">
        <select wire:model.defer="project_id" class="w-full border-2 border-green-200 rounded p-2 focus:border-green-500 focus:ring" required>
            <option value="">Select Project</option>
            @foreach($projects as $project)
                <option value="{{ $project->id }}">{{ $project->title }}</option>
            @endforeach
        </select>
        <input type="text" wire:model.defer="title" placeholder="Title" class="w-full border-2 border-green-200 rounded p-2 focus:border-green-500 focus:ring" required>
        <select wire:model.defer="status" class="w-full border-2 border-green-200 rounded p-2 focus:border-green-500 focus:ring" required>
            <option value="">Select Status</option>
            <option value="todo">To Do</option>
            <option value="in progress">In Progress</option>
            <option value="done">Done</option>
        </select>
        <input type="date" wire:model.defer="due_date" class="w-full border-2 border-green-200 rounded p-2 focus:border-green-500 focus:ring">
        <div class="flex gap-2">
            <button type="submit" class="bg-green-600 hover:bg-green-700 transition text-white px-4 py-2 rounded shadow">{{ $isEdit ? 'Update' : 'Add' }} Task</button>
            @if($isEdit)
                <button type="button" wire:click="resetForm" class="bg-gray-400 hover:bg-gray-500 transition text-white px-4 py-2 rounded">Cancel</button>
            @endif
        </div>
    </form>
    <div class="space-y-4">
        @forelse($tasks as $task)
            <div class="border-2 border-green-100 bg-white rounded p-4 flex flex-col md:flex-row md:items-center md:justify-between shadow-sm hover:shadow-lg transition">
                <div>
                    <div class="font-semibold text-lg text-green-800">{{ $task->title }}</div>
                    <div class="text-gray-600 mb-1">Status: <span class="font-medium">{{ ucfirst($task->status) }}</span></div>
                    <div class="text-gray-500 text-sm">Project: {{ $task->project->title ?? 'N/A' }}</div>
                    <div class="text-sm text-gray-500">Due: <span class="font-medium">{{ $task->due_date }}</span></div>
                </div>
                <div class="flex gap-2 mt-2 md:mt-0">
                    <button wire:click="edit({{ $task->id }})" class="bg-yellow-400 hover:bg-yellow-500 transition px-3 py-1 rounded shadow">Edit</button>
                    <button wire:click="delete({{ $task->id }})" class="bg-red-500 hover:bg-red-600 transition text-white px-3 py-1 rounded shadow">Delete</button>
                </div>
            </div>
        @empty
            <div class="text-gray-500">No tasks found.</div>
        @endforelse
    </div>
</div>
