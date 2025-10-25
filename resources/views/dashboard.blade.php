<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-6 flex gap-4">
                <a href="?tab=projects" class="px-4 py-2 rounded {{ request('tab', 'projects') == 'projects' ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700' }}">Projects</a>
                <a href="?tab=tasks" class="px-4 py-2 rounded {{ request('tab') == 'tasks' ? 'bg-green-600 text-white' : 'bg-gray-200 text-gray-700' }}">Tasks</a>
                @if(auth()->user() && auth()->user()->hasRole('Admin'))
                    <a href="?tab=activity" class="px-4 py-2 rounded {{ request('tab') == 'activity' ? 'bg-purple-600 text-white' : 'bg-gray-200 text-gray-700' }}">Activity Log</a>
                @endif
            </div>
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4">
                @if(request('tab', 'projects') == 'projects')
                    @livewire('project-management')
                @elseif(request('tab') == 'tasks')
                    @livewire('task-management')
                @elseif(request('tab') == 'activity' && auth()->user() && auth()->user()->hasRole('Admin'))
                    @livewire('activity-log-viewer')
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
