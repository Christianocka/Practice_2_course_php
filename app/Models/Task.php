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

    public function scopeFilters($query, $filters)
    {
        if (!empty($filters['start_at'])) {
            $query->whereDate('start_at', '>=', $filters['start_at']);
        }

        if (!empty($filters['end_at'])) {
            $query->whereDate('end_at', '<=', $filters['end_at']);
        }

        if (!empty($filters['tags'])) {
            $query->whereJsonContains('tags', $filters['tags']);
        }

        if (!empty($filters['title'])) {
            $query->where('title', 'like', '%' . $filters['title'] . '%');
        }

        return $query;
    }
}
