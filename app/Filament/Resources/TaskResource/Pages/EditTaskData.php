<?php

namespace App\Filament\Resources\TaskResource\Pages;

use App\Filament\Resources\TaskResource;
use App\Models\Task;
use Filament\Actions;
use Filament\Forms\Form;
use Filament\Forms;
use Filament\Resources\Pages\EditRecord;

class EditTaskData extends EditRecord
{
    protected static string $resource = TaskResource::class;

    protected static ?string $title = 'Data';

    protected static ?string $navigationIcon = 'heroicon-o-square-3-stack-3d';

    public static function shouldRegisterNavigation(array $parameters = []): bool
    {
        return parent::shouldRegisterNavigation($parameters);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Toggle::make('import_settings.overwrite')
                    ->columnSpanFull()
                    ->helperText('Allow overwrite exist email'),

                Forms\Components\Section::make('File Fields')
                    ->columnSpan(1)
                    ->schema(fn(?Task $record) => static::fileFields($record)),

                Forms\Components\Section::make('Additional Fields')
                    ->columnSpan(1)
                    ->schema([
                        Forms\Components\Toggle
                            ::make('import_settings.additional_fields.task_id')
                            ->label('task_id'),
                    ]),

            ]);
    }

    public static function fileFields(?Task $task): array
    {
        $fields = [];

        foreach ($task->import_settings->getFileFields() as $key) {
            $fields[] = Forms\Components\Toggle
                ::make('import_settings.file_fields_settings.' . $key . '.allow')
                ->label($key)
                ->disabled(fn() => in_array($key, TaskResource::getRequiredFileKeys()))
                ->required(fn() => in_array($key, TaskResource::getRequiredFileKeys()));
        }
        return $fields;
    }
}
