<?php

namespace App\Models;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldBeEncrypted;

class Queue implements ShouldQueue, ShouldBeUnique, ShouldBeEncrypted
{
    public $task;
    public $uniqueFor = 3600;
    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    public function uniqueId(): string
    {
        return $this->task->id;
    }
}
