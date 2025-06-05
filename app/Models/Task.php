<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'parent_id',
        'title',
        'description',
        'is_done',
        'priority'
    ];

    protected $casts = [
        'tags' => 'array',
        'start_at' => 'datetime',
        'end_at' => 'datetime',
    ];

    public function parent()
    {
        return $this->belongsTo(Task::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Task::class, 'parent_id')->with('children');
    }

    public function files()
    {
        return $this->hasMany(File::class);
    }
}
