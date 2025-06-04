<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'task',
        'is_done',
        'priority',
        'category',
        'tags',
        'start_at',
        'end_at',
    ];

    protected $casts = [
        'tags' => 'array',
        'start_at' => 'datetime',
        'end_at' => 'datetime',
    ];
}
