<?php

namespace App\Filament\Resources\TaskResource\Widgets;

use App\Models\TaskTimetable;
use Filament\Support\Colors\Color;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class StatsOverview extends BaseWidget
{
    protected int|string|array $columnSpan = 1;

    public null|Model|TaskTimetable $record = null;

    protected static ?string $pollingInterval = null;//'5s';

    protected function getStats(): array
    {
        $task_timetable = $this->record->timetable();
        $count = $task_timetable->count();

        if (!$count) {
            return [
                Stat::make('Empty', 'No data loaded')
                    ->chart([])
                    ->color(Color::Gray),
            ];
        }

        $first = $task_timetable->clone()->orderBy('send_date')->first();
        $last = $task_timetable->clone()->orderByDesc('send_date')->first();

        $days = ceil(Carbon::make($first->send_date)->floatDiffInDays($last->send_date, false));

        return [
            Stat::make('Start At: ' . $first->send_date, 'End At: ' . $last->send_date)
                ->description($days . ' days / ' . $count . ' items')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->chart($this->record->daily_timetable)
                ->color('success'),
        ];
    }

    protected function getColumns(): int
    {
        return 1;
    }
}
