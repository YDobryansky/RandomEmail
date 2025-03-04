<?php

namespace App\Filament\Resources\TaskResource\Pages;

use App\Actions\Task\TaskActions;
use App\Filament\Resources\TaskResource;
use App\Models\Task;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Support\Colors\Color;

class EditTask extends EditRecord
{
    protected static string $resource = TaskResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
                ->label('Delete All data')
                ->color(Color::Red)
                ->requiresConfirmation()
                ->modalDescription('Remove all data!!! Task, Jobs, TimeTable')
                ->action(function (?Task $record, Actions\DeleteAction $action) {
                    $result = TaskActions::delete($record);

                    if (!$result) {
                        $action->failure();
                        return;
                    }

                    $action->success();
                }),
//
//            Actions\Action::make('Timetable/Jobs')
//                ->label('Timetable/Jobs')
//                ->icon('heroicon-m-eye')
//                ->url('timetable')
//                ->disabled(fn(Task $record) => !$record->file),

        ];
    }
}
