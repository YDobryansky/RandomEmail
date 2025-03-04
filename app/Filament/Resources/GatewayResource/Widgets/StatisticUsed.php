<?php

namespace App\Filament\Resources\GatewayResource\Widgets;

use App\Models\Dispatch;
use App\Models\Gateway;
use Filament\Widgets\ChartWidget;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class StatisticUsed extends ChartWidget
{
    protected static ?string $heading = 'Chart';

    public null|Model|Gateway $record = null;
    /**
     * @var array|mixed
     */
    private ?array $chart_data = null;

    private int $days = 7;

    protected static ?string $pollingInterval = null;

    public function getHeading(): string|Htmlable|null
    {
        $now = Carbon::now();
        return 'From ' . $now->format('Y.m.d') . ' to '. $now->subDays($this->days)->format('Y.m.d') . ' ';
    }

    protected function getChartData(): array
    {
        if ($this->chart_data !== null) {
            return $this->chart_data;
        }

        $this->chart_data = [
            'count' => 0,
            'stat' => null,
        ];

        if (!$this->record) {
            return $this->chart_data;
        }

        $task_timetable = Dispatch::where([
            ['gateway_id', '=', $this->record->id],
            ['send_date', '>', (string)Carbon::now()],
        ]);

        $this->chart_data['count'] = $task_timetable->count();

        if (!$this->chart_data['count']) {
            return $this->chart_data;
        }

        $start = Carbon::now();

        $this->chart_data['stat'] = $task_timetable
            ->clone()
            ->selectRaw("DATE_FORMAT(send_date, '%Y-%m-%d %H') AS Date, COUNT(*) AS Count")
            ->whereBetween('send_date', [
                (string)$start,
                (string)$start->addDays($this->days)->setTime(23, 59)
            ])
            ->groupByRaw("DATE_FORMAT(send_date,'%Y-%m-%d %H')")
            ->get();

        return $this->chart_data;
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
                    'label' => 'Messages sending',
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
