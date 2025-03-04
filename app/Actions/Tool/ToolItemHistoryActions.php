<?php
/**
 * Create: Volodymyr
 */

namespace App\Actions\Tool;

use App\Actions\MassActions;
use App\Models\ToolItem;
use App\Models\ToolItemHistory;

class ToolItemHistoryActions
{
    public static function add($tool_id, $tool_item_id, $key, $value = null)
    {
        return ToolItemHistory::create([
            'tool_id' => $tool_id,
            'tool_item_id' => $tool_item_id,
            'key' => $key,
            'value' => $value,
        ]);
    }

    public static function data(int $tool_id, int $tool_item_id, string $key, mixed $value = null)
    {
        return [
            'tool_id' => $tool_id,
            'tool_item_id' => $tool_item_id,
            'key' => $key,
            'value' => json_encode($value),
        ];
    }

    public static function deleteByToolID($tool_id)
    {
        return ToolItemHistory::where('tool_id', $tool_id)->delete();
    }

    public static function massUpdate(): MassActions
    {
        return new MassActions(ToolItemHistory::class);
    }

    public static function dataExceptionItem(ToolItem $item, \Exception $exception, array $data): array
    {
        return [
            'tool_id' => $item->tool_id,
            'tool_item_id' => $item->id,
            'key' => 'Exception:' . get_class($exception),
            'value' => json_encode([
                'message' => $exception->getMessage(),
                'data' => $data
            ]),
        ];
    }
}
