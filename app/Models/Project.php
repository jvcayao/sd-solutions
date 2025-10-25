<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Project extends Model implements Auditable
{
    /** @use HasFactory<\Database\Factories\ProjectFactory> */
    use HasFactory, \OwenIt\Auditing\Auditable, SoftDeletes;

    protected $fillable = ['user_id', 'title', 'description', 'deadline'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function getProgressAttribute()
    {
        $total = $this->tasks()->count();
        $done = $this->tasks()->where('status', 'done')->count();

        return $total > 0 ? round(($done / $total) * 100, 2) : 0;
    }
}
