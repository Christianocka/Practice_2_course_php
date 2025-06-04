<?php

namespace App\Models;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldBeEncrypted;

class Queue implements ShouldQueue, ShouldBeUnique, ShouldBeEncrypted
{
    /**
     * Экземпляр задачи.
     *
     * @var \App\Models\Task
     */
    public $task;

    /**
     * Количество секунд, по истечении которых уникальная блокировка задания будет снята.
     *
     * @var int
     */
    public $uniqueFor = 3600;

    /**
     * Создать новый экземпляр очереди.
     *
     * @param  \App\Models\Task  $task
     * @return void
     */
    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    /**
     * Получить уникальный идентификатор задания.
     */
    public function uniqueId(): string
    {
        return $this->task->id;
    }
}
