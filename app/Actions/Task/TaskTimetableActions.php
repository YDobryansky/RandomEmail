<?php
/**
 * Create: Volodymyr
 */

namespace App\Actions\Task;

use App\Models\Task;
use App\Models\TaskTimetable;
use App\Services\TaskTimeForJob;
use App\TDO\ClientVaultDTO;
use Illuminate\Support\Carbon;
use Rap2hpoutre\FastExcel\FastExcel;

class TaskTimetableActions
{

    static function createFromFile(Task $task): int
    {
        ini_set('max_execution_time', 3000);
        ini_set('memory_limit', "512M");

        $file = $task->file;
        $min = $task->items_min_per_hour ?? 0;
        $max = $task->items_max_per_hour ?? 60;

        $timer = new TaskTimeForJob($min, $max);
        $timer->setRatios($task->daily_timetable ?? []);

        $file = storage_path('app/' . $file);

        $rows = [];
        $count = 0;

        TaskTimetable::where('task_id', $task->id)->delete();

        (new FastExcel)->import(
            $file,
            function ($line) use ($timer, $task, &$rows, &$count) {
                $user = ClientVaultDTO::fromArray($line);

                $rows[] = [
                    'send_date' => (string)$timer->getNextTime(),
                    'task_id' => $task->id,
                    'index' => $count,
                    'data' => $user,
                ];

                $count++;

                if (count($rows) === 500) {
                    TaskTimetable::insert($rows);
                    $rows = [];
                }

            }

        );

        if (!empty($rows)) {
            TaskTimetable::insert($rows);
        }

        return $count;
    }

    public static function loadOrUpdateSendDate(Task $task): int
    {
        $count = TaskTimetable::where('task_id', $task->id)->count();
        if ($count) {
            $count = static::updateSendDate($task);
        } else {
            $count = static::createFromFile($task);
        }
        return $count;
    }

    public static function updateSendDate(Task $task)
    {
        $min = $task->items_min_per_hour ?? 0;
        $max = $task->items_max_per_hour ?? 60;

        $timer = new TaskTimeForJob($min, $max);
        $timer->setRatios($task->daily_timetable ?? [])
            ->setDateStart(Carbon::make($task->start_at));

        $count = TaskTimetable::where('task_id', $task->id)->count();
        $rows = [];

        for ($index = 0; $index < $count; $index++) {
            $rows[] = [
                'send_date' => (string)$timer->getNextTime(),
                'task_id' => $task->id,
                'index' => $index,
            ];

            if (count($rows) === 500) {
                TaskTimetable::upsert($rows, uniqueBy: ['task_id', 'index'], update: ['send_date']);
                $rows = [];
            }
        }

        if (!empty($rows)) {
            TaskTimetable::upsert($rows, uniqueBy: ['task_id', 'index'], update: ['send_date']);
        }

        return $count;
    }


}
