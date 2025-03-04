<?php

namespace App\Actions\Tool;

use App\Actions\Api\ApiActions;
use App\API\Common\Interfaces\ServiceInterface;
use App\Enums\ToolItemStateEnum;
use App\Enums\ToolStatusEnum;
use App\Helpers\File\FileCSV;
use App\Helpers\Value\DataModifier;
use App\Jobs\ToolJob;
use App\Models\Tool;
use App\Models\ToolItem;
use App\Models\ToolItemHistory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

/**
 * Create: Volodymyr
 */
class ToolActions
{
    public static function run(Tool $tool): int
    {
        $tool->status = ToolStatusEnum::STARTED;
        $tool->save();

        $total = ToolItemActions::importFromTool($tool);

        $tool->status = ToolStatusEnum::IN_PROGRESS;
        $tool->items_total = $total;
        $tool->step = 1;
        $tool->items_error = 0;
        $tool->items_success = 0;
        $tool->save();

        ToolJob::dispatch($tool->id);

        return $total;
    }

    public static function step(int $tool_id): bool
    {
        $tool = Tool::with('api')->findOrFail($tool_id);

        DB::beginTransaction();
        try {
            $items = ToolItemActions::getChunk($tool_id, $tool->items_per_step);
            ToolItemActions::updateStatus($items, ToolItemStateEnum::IN_PROGRESS);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        }

        if ($items->isEmpty()) {
            $tool->status = ToolStatusEnum::FINISHED;
            $tool->save();
            return true;
        }

        /**
         * @var ServiceInterface $driver
         */

        $success = ToolItemActions::updateUseApi(
            $items,
            $tool->api,
            (new DataModifier($tool->settings[Tool::SETTING_MODIFIER] ?? []))
        );

        $tool->items_success += $success;
        $tool->items_error += $items->count() - $success;
        $tool->step++;

        if (($tool->step - 1) * $tool->items_per_step < $tool->items_total) {
            $tool->save();
            ToolJob::dispatch($tool_id);
        } else {
            $tool->status = ToolStatusEnum::FINISHED;
            $tool->save();
        }

        return true;
    }

    public static function apiRequestArgs(Tool $tool): array
    {
        return ApiActions::requestArgs($tool->api);
    }

    public static function sourceArgs(Tool $tool): array
    {
        return (new FileCSV(Storage::disk()->path($tool->file)))->getHeader();
    }

    public static function responseArgs(Tool $tool): array
    {
        return ApiActions::responseArgs($tool->api);
    }

    public static function sourceReplacedArgs(Tool $tool): array
    {
        static $args = [];

        return $args[$tool->file] ??= array_map(
            fn($item) => '{' . $item . '}',
            self::sourceArgs($tool)
        );
    }

    public static function delete(Tool $tool): ?bool
    {
        ToolItemActions::deleteByToolId($tool->id);
        ToolItemHistoryActions::deleteByToolID($tool->id);
        if ($tool->file) {
            // @todo check
            Storage::disk()->delete($tool->file);
        }
        return $tool->delete();
    }

}
