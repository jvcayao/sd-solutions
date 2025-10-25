<div class="max-w-3xl mx-auto p-4">
    <h2 class="text-3xl font-extrabold mb-6 text-blue-700 flex items-center gap-2">
        <svg class="w-7 h-7 text-blue-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-2a2 2 0 012-2h2a2 2 0 012 2v2m-6 4h6a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
        Projects
    </h2>
    @if (session()->has('success'))
        <div class="bg-green-100 text-green-800 p-2 rounded mb-2 shadow">{{ session('success') }}</div>
    @endif
    <form wire:submit.prevent="{{ $isEdit ? 'update' : 'create' }}" class="mb-8 bg-white rounded shadow p-4 space-y-3">
        <input type="text" wire:model.defer="title" placeholder="Title" class="w-full border-2 border-blue-200 rounded p-2 focus:border-blue-500 focus:ring" required>
        <textarea wire:model.defer="description" placeholder="Description" class="w-full border-2 border-blue-200 rounded p-2 focus:border-blue-500 focus:ring"></textarea>
        <input type="date" wire:model.defer="deadline" class="w-full border-2 border-blue-200 rounded p-2 focus:border-blue-500 focus:ring">
        <div class="flex gap-2">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 transition text-white px-4 py-2 rounded shadow">{{ $isEdit ? 'Update' : 'Add' }} Project</button>
            @if($isEdit)
                <button type="button" wire:click="resetForm" class="bg-gray-400 hover:bg-gray-500 transition text-white px-4 py-2 rounded">Cancel</button>
            @endif
        </div>
    </form>
    <div class="space-y-4">
        @forelse($projects as $project)
            <div class="border-2 border-blue-100 bg-white rounded p-4 flex flex-col md:flex-row md:items-center md:justify-between shadow-sm hover:shadow-lg transition">
                <div>
                    <div class="font-semibold text-lg text-blue-800">{{ $project->title }}</div>
                    <div class="text-gray-600 mb-1">{{ $project->description }}</div>
                    <div class="text-sm text-gray-500">Deadline: <span class="font-medium">{{ $project->deadline }}</span></div>
                    <div class="text-xs text-gray-400">Progress: {{ $project->progress }}%</div>
                </div>
                <div class="flex gap-2 mt-2 md:mt-0">
                    <button wire:click="edit({{ $project->id }})" class="bg-yellow-400 hover:bg-yellow-500 transition px-3 py-1 rounded shadow">Edit</button>
                    <button wire:click="delete({{ $project->id }})" class="bg-red-500 hover:bg-red-600 transition text-white px-3 py-1 rounded shadow">Delete</button>
                </div>
            </div>
        @empty
            <div class="text-gray-500">No projects found.</div>
        @endforelse
    </div>
</div>
