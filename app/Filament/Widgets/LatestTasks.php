<?php

namespace App\Filament\Widgets;

use App\Enums\TaskStateEnum;
use App\Models\Task;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Model;

class LatestTasks extends BaseWidget
{

    public function table(Table $table): Table
    {
        return $table
            ->poll('300s')
            ->query(
                Task::query()->orderByDesc('id')->limit(10)
            )
            ->columns([
                TextColumn::make('id')
                    ->sortable(),
                TextColumn::make('name')
                    ->searchable(),
//                TextColumn::make('items_min_per_hour')
//                    ->label('Min per hour')
//                    ->numeric(),
//                TextColumn::make('items_max_per_hour')
//                    ->label('Max per hour')
//                    ->numeric(),
//                TextColumn::make('tags.name')
//                    ->badge(),
                TextColumn::make('jobs_start_at')
                    ->label('Start At')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('jobs_finish_at')
                    ->label('Finish At')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('state')
                    ->sortable()
                    ->state(function (Model $record) {
                        return TaskStateEnum::from($record->state)->name;
                    }),
                TextColumn::make('jobs_total')
                    ->numeric(),
                TextColumn::make('jobs_failed')
                    ->label('Failed')
                    ->numeric(),
                TextColumn::make('jobs_good')
                    ->label('Good')
                    ->numeric(),
//                TextColumn::make('gateway.name')
//                    ->badge(),
            ]);
    }
}
