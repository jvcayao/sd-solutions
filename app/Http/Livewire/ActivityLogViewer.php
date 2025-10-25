<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use OwenIt\Auditing\Models\Audit;

class ActivityLogViewer extends Component
{
    public $logs = [];

    public function mount()
    {
        // Only admins can view logs
        if (! Auth::user() || ! Auth::user()->hasRole('Admin')) {
            abort(403);
        }
        $this->logs = Audit::with('user')->latest()->limit(20)->get();
    }

    public function render()
    {
        return view('livewire.activity-log-viewer');
    }
}
