<div class="max-w-3xl mx-auto p-4">
    <h2 class="text-2xl font-bold mb-4 text-purple-700 flex items-center gap-2">
        <svg class="w-6 h-6 text-purple-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        Activity Log
    </h2>
    <div class="bg-white rounded shadow p-4 space-y-2">
        @forelse($logs as $log)
            <div class="border-b last:border-b-0 pb-2 mb-2 last:mb-0">
                <div class="text-sm text-gray-700">
                    <span class="font-semibold">{{ $log->user->name ?? 'System' }}</span>
                    <span class="text-gray-500">{{ $log->event }}</span>
                    <span class="text-gray-400">on</span>
                    <span class="font-mono text-xs">{{ class_basename($log->auditable_type) }}</span>
                    <span class="text-gray-400">#{{ $log->auditable_id }}</span>
                </div>
                <div class="text-xs text-gray-500">{{ $log->created_at->diffForHumans() }}</div>
            </div>
        @empty
            <div class="text-gray-500">No activity found.</div>
        @endforelse
    </div>
</div>
