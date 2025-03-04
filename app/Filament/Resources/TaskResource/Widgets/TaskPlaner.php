<?php

namespace App\Filament\Resources\TaskResource\Widgets;

use App\Models\TaskTimetable;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Model;

class TaskPlaner extends BaseWidget
{

    public ?Model $record = null;

    public function table(Table $table): Table
    {
        $id = (int)$this->record?->id;
        return $table
            ->query(
                TaskTimetable::query()
                    ->where('task_id', $id)
            )
            ->columns([
                Tables\Columns\TextColumn::make('index'),
                Tables\Columns\TextColumn::make('send_date'),
            ]);
    }


}
