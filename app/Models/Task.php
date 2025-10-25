<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Task extends Model implements Auditable
{
    /** @use HasFactory<\Database\Factories\TaskFactory> */
    use HasFactory, \OwenIt\Auditing\Auditable, SoftDeletes;

    protected $fillable = [
        'project_id', 'title', 'status', 'due_date',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
