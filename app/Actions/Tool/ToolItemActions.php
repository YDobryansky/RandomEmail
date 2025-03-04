<?php
/**
 * Create: Volodymyr
 */

namespace App\Actions\Tool;

use App\Actions\Api\ApiActions;
use App\Actions\MassActions;
use App\Enums\ToolItemStateEnum;
use App\Helpers\Value\DataModifier;
use App\Models\Api;
use App\Models\Tool;
use App\Models\ToolItem;
use Illuminate\Database\Eloquent\Collection;
use OpenSpout\Common\Exception\InvalidArgumentException;
use OpenSpout\Common\Exception\IOException;
use OpenSpout\Common\Exception\UnsupportedTypeException;
use OpenSpout\Writer\Exception\WriterNotOpenedException;
use Rap2hpoutre\FastExcel\FastExcel;

class ToolItemActions
{
    public static function importFromTool(Tool $tool): int
    {
        ini_set('max_execution_time', 3000);
        ini_set('memory_limit', "512M");

        $file = storage_path('app/' . $tool->file);

        $rows = [];
        $count = 0;

        static::deleteByToolId($tool->id);
        ToolItemHistoryActions::deleteByToolID($tool->id);

        (new FastExcel)->import(
            $file,
            function ($line) use (&$rows, &$count, $tool) {

                $rows[] = [
                    'tool_id' => $tool->id,
                    'state' => ToolItemStateEnum::CREATE->value,
                    'values' => json_encode([
                        ToolItem::SOURCE => $line
                    ]),
                ];

                $count++;

                if (count($rows) === 500) {
                    ToolItem::insert($rows);
                    $rows = [];
                }

            }

        );

        if (!empty($rows)) {
            ToolItem::insert($rows);
        }

        return $count;
    }

    public static function deleteByToolId($tool_id)
    {
        return ToolItem::where('tool_id', $tool_id)->delete();
    }

    /**
     * @throws WriterNotOpenedException
     * @throws IOException
     * @throws UnsupportedTypeException
     * @throws InvalidArgumentException
     */
    public static function exportFromTool(Tool $tool): \Symfony\Component\HttpFoundation\StreamedResponse|string
    {
        $items_generator = function (Tool $tool): \Generator {
            $cursor = ToolItem::where('tool_id', $tool->id)->cursor();
            foreach ($cursor as $item) {
                yield $item;
            }
        };

        return (new FastExcel($items_generator($tool)))
            ->download(
                'data-' . date('Y-m-d-H-i-s') . '.csv',
                function (ToolItem $item) use ($tool) {
                    $export = $tool->settings['export'] ?? null;
                    $data = $item->values;
                    $data['state'] = $item->state;
                    $data['id'] = $item->id;
                    $out = [];
                    foreach ($export as $path) {
                        $keys = explode('.', $path);
                        $value = $data;
                        $_key = end($keys);
                        if (isset($out[$_key])) {
                            $_key = $path;
                        }
                        foreach ($keys as $key) {
                            $value = $value[$key] ?? null;
                            if ($value === null) {
                                break;
                            }
                        }
                        $out[$_key] = is_scalar($value) && !is_bool($value)
                            ? $value
                            : json_encode($value);
                    }

                    return $out;
                }
            );
    }

    public static function getChunk(int $tool_id, int $per_step = 10, int $step = 0, ToolItemStateEnum $state = ToolItemStateEnum::CREATE): Collection|null
    {
        return ToolItem::where('tool_id', $tool_id)
            ->where('state', $state->value)
            ->skip($step * $per_step)
            ->take($per_step)
            ->get();
    }

    public static function updateStatus(Collection $items, ToolItemStateEnum $status)
    {
        return ToolItem::whereIn('id', $items->pluck('id')->toArray())
            ->update(['state' => $status->value]);
    }

    public static function massUpdate(): MassActions
    {
        return new MassActions(ToolItem::class);
    }

    public static function updateUseApi(Collection $items, Api $api, DataModifier $modifier): int
    {
        $update_item = static::massUpdate();
        $inset_history = ToolItemHistoryActions::massUpdate();
        $success = 0;

        $items->each(function (ToolItem $item) use (
            $api,
            &$update_item,
            $modifier,
            &$success,
            &$inset_history
        ) {

            $data = $item->toArray();
            try {
                $request = $modifier->replace($item->values[ToolItem::SOURCE] ?? []);
                $result = ApiActions::send($api, $request);
                $data['values'][ToolItem::RESULT] = $result->toArray();
                $data['state'] = ToolItemStateEnum::SUCCESS->value;
                $success++;
            } catch (\Exception $e) {
                $data['state'] = ToolItemStateEnum::ERROR->value;
                $data['values'][ToolItem::RESULT] = [];
                $inset_history->add(
                    ToolItemHistoryActions::dataExceptionItem($item, $e, $request ?? $data['values'])
                );
            }

            $data['values'] = json_encode($data['values']);

            $update_item->add($data);
        });

        $update_item->upsert(['id'], ['values', 'state']);
        $inset_history->insert();

        return $success;
    }

}
