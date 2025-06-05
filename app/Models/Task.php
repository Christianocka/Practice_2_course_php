<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
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

    public function files()
    {
        return $this->hasMany(File::class);
    }

}
