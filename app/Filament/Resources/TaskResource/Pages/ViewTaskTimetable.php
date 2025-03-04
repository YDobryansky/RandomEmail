<?php

namespace App\Filament\Resources\TaskResource\Pages;

use App\Actions\Task\TaskActions;
use App\Actions\Task\TaskTimetableActions;
use App\Filament\Resources\TaskResource;
use App\Models\Task;
use App\Models\TaskTimetable;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;
use Filament\Pages\Dashboard;
use Filament\Support\Colors\Color;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Model;

class ViewTaskTimetable extends ViewRecord
{
    protected static string $resource = TaskResource::class;

    protected static ?string $title = 'Timetable';

    public function getTitle(): string|Htmlable
    {
        return $this->record?->name . ' / ' . static::$title;
    }

    protected function getHeaderWidgets(): array
    {
        return [
            TaskResource\Widgets\StatsOverview::class
        ];
    }

    public function getHeaderWidgetsColumns(): int|string|array
    {
        return 1;
    }

    protected function getHeaderActions(): array
    {
        return [
//            Actions\Action::make('Task')
//                ->icon('heroicon-o-pencil')
//                ->color(Color::Gray)
//                ->url('edit'),

            Actions\Action::make('Load from file')
                ->icon('heroicon-m-plus')
                ->color(Color::Purple)
                ->action(function (Task $record) {
                    $count = TaskTimetableActions::createFromFile($record);
                    Notification::make()
                        ->title('Create successfully ' . $count . ' items')
                        ->success()
                        ->send();

                    return redirect()->to(TaskResource::getUrl('timetable', ['record' => $record]));
                }),

            Actions\ActionGroup::make([
                Actions\Action::make('createJobs')
                    ->icon('heroicon-m-play')
                    ->color(Color::Green)
                    ->action(function (?Task $record) {
                        $count = TaskActions::creteJobs($record);
                        Notification::make()
                            ->persistent()
                            ->title('Create successfully ' . $count . ' Jobs')
                            ->success()
                            ->send();
                    }),
                Actions\Action::make('deleteJobs')
                    ->icon('heroicon-m-x-mark')
                    ->color(Color::Red)
                    ->action(function (?Task $record) {
                        $delete = TaskActions::removeJobs($record);
                        Notification::make()
                            ->title('Deleted jobs ' . $delete . '. ')
                            ->warning()
                            ->send();
                    }),
            ])
                ->label('Jobs Actions')
                ->icon('heroicon-m-ellipsis-vertical')
//                ->size(ActionSize::Small)
                ->color(Color::Cyan)
                ->button(),

        ];
    }

    protected function getFooterWidgets(): array
    {
        return [
//            TaskResource\Widgets\TimeTableChart::class,
            TaskResource\Widgets\TaskPlaner::class
        ];
    }

    public function getFooterWidgetsColumns(): int|string|array
    {
        return 1;
    }

}
