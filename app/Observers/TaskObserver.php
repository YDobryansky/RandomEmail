<?php

namespace App\Observers;

use App\Enums\TaskStateEnum;
use App\Models\Task;
use App\Services\TelegramService;

class TaskObserver
{
    public function created(Task $task): void
    {
        if (($task->state ?? null) === TaskStateEnum::CREATED->value) {
            TelegramService::send("Task #{$task->id} created");
        }
    }

    public function updated(Task $task): void
    {
        if ($task->isDirty('state') && $task->state === TaskStateEnum::FINISHED->value) {
            TelegramService::send("Task #{$task->id} finished");
        }
    }
}
