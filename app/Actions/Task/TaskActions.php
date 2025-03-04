<?php
/**
 * Create: Volodymyr
 */

namespace App\Actions\Task;

use App\Enums\DispatchStatusEnum;
use App\Enums\TaskStateEnum;
use App\Models\Dispatch;
use App\Models\Job;
use App\Models\Task;
use App\Models\TaskTimetable;
use App\TDO\ClientVaultDTO;
use App\TDO\JobSettingsDTO;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class TaskActions
{
    public static function removeJobs(Task $task): int
    {
        $result = Dispatch::where('task_id', $task->id)->delete();

        $task->state = TaskStateEnum::TERMINATED->value;
        $task->jobs_failed = 0;
        $task->jobs_good = 0;
        $task->jobs_total = 0;
        $task->jobs_start_at = null;
        $task->jobs_finish_at = null;
        $task->save();

        return $result;
    }

    public static function updateJobsStatus(Task $task, int $status_old, int $status_new): int
    {
        return Job::where([
            ['task_id', '=', $task->id],
            ['status', '=', $status_old],
        ])->update(['status' => $status_new]);
    }

    public static function changeState(Task $task, TaskStateEnum $state, bool|null $job_send_status = null): bool
    {
        $task->state = $state->value;
        if ($job_send_status !== null) {
            if ($job_send_status) {
                $task->jobs_good = DB::raw('jobs_good + 1');
            } else {
                $task->jobs_failed = DB::raw('jobs_failed + 1');
            }
        }
        return $task->save();
    }

    public static function delete(Task $task): ?bool
    {
        Dispatch::where('task_id', $task->id)->delete();
        TaskTimetable::where('task_id', $task->id)->delete();
        return $task->delete();
    }

    public static function creteJobs(Task $task): int
    {
        $count = 0;
        $time = (string)now();

        $fields = array_fill_keys(collect($task->import_settings->getFileFieldsSettings())
            ->where('allow', true)
            ->keys()->toArray(), true);

        $additional_fields = $task->import_settings->getAdditionalFields();
        $settings = (string)(new JobSettingsDTO())
            ->setOverwrite($task->import_settings->getOverwrite());

        TaskTimetable::where('task_id', $task->id)
            ->chunk(500, function (Collection $timetables)
            use (&$count, $task, $time, $fields, $additional_fields, $settings) {

                $insert = [];
                foreach ($timetables as $timetable) {
                    $data = array_intersect_key($timetable->data->toArray(), $fields);

                    if ($additional_fields['task_id'] ?? null) {
                        $data['task_id'] = $timetable->task_id;
                    }

                    $insert[] = [
                        'task_id' => $timetable->task_id,
                        'send_date' => $timetable->send_date,
                        'send_status' => DispatchStatusEnum::Create->value,
                        'created_at' => $time,
                        'updated_at' => $time,
                        'gateway_id' => $task->gateway_id,
                        'data' => json_encode($data),
                        'settings' => $settings,
                    ];
                }
                Dispatch::insert($insert);

                $count += count($insert);

            });

        $jobs_start_at = $task->timetable()->select('send_date')->orderBy('send_date')->first()?->send_date;
        $jobs_finish_at = $task->timetable()->select('send_date')->orderByDesc('send_date')->first()?->send_date;

        $task->state = TaskStateEnum::WAITING->value;
        $task->jobs_failed = 0;
        $task->jobs_good = 0;
        $task->jobs_total = $count;
        $task->jobs_start_at = $jobs_start_at;
        $task->jobs_finish_at = $jobs_finish_at;
        $task->save();

        return $count;
    }

    public static function getFileInformation(?Task $task): array
    {

        $file_keys = [];
        if ($task && $task->file) {
            $file_path = storage_path('app/' . $task->file);

            // get first file line
            $file = fopen($file_path, 'r');
            $file_keys = fgetcsv($file);
            if ($file_keys && !empty($file_keys[0])) {
                $file_keys[0] = str_replace("\u{FEFF}", '', (string)$file_keys[0]);
            }

            fclose($file);
        }
        $allow_keys = ClientVaultDTO::defaultKeys();

        return ['allow_keys' => $allow_keys, 'file_keys' => $file_keys];
    }

}
