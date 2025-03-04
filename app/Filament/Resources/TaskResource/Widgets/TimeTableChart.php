<?php

namespace App\Filament\Resources\TaskResource\Widgets;

use App\Models\TaskTimetable;
use Filament\Support\Colors\Color;
use Filament\Widgets\ChartWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class TimeTableChart extends ChartWidget
{
    protected static ?string $heading = 'Statistic Sending Messages';

    public null|Model|TaskTimetable $record = null;
    protected static ?string $pollingInterval = null;//'5s';

    protected ?array $chart_data = null;

    protected function getChartData(): array
    {
        if ($this->chart_data !== null) {
            return $this->chart_data;
        }

        $this->chart_data = [
            'first' => null,
            'count' => 0,
            'stat' => null,
        ];

        if (!$this->record) {
            return $this->chart_data;
        }

        $task_timetable = $this->record->timetable();

        $this->chart_data['count'] = $task_timetable->count();

        if (!$this->chart_data['count']) {
            return $this->chart_data;
        }

        $this->chart_data['first'] = Carbon::make($task_timetable->clone()->orderBy('send_date')->first()->send_date);
        $this->chart_data['stat'] = $task_timetable
            ->clone()
            ->selectRaw("DATE_FORMAT(send_date, '%Y-%m-%d %H') AS Date, COUNT(*) AS Count")
            ->whereBetween('send_date', [
                (string)$this->chart_data['first'],
                (string)$this->chart_data['first']->clone()->addDays(5)->setTime(23, 59)
            ])
            ->groupByRaw("DATE_FORMAT(send_date,'%Y-%m-%d %H')")
            ->get();

        return $this->chart_data;
    }

    public function getHeading(): string|Htmlable|null
    {

        $chart_data = $this->getChartData();

        if (!$chart_data['first']) {
            return 'No information';
        }

        return parent::getHeading() . ' Static messages send from ' . $chart_data['first']->format('d.m.Y') . ' ' ;
    }

    protected function getData(): array
    {
        if (!$this->record) {
            return [];
        }

        $chart_data = $this->getChartData();


        if (!$chart_data['count']) {
            return [];
        }

        return [
            'datasets' => [
                [
                    'label' => 'Messages send',
                    'data' => $chart_data['stat']->pluck('Count')->toArray(),
                    'tension' => 0.5
                ],
            ],
            'labels' => $chart_data['stat']->pluck('Date')->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
