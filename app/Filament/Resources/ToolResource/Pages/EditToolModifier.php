<?php

namespace App\Filament\Resources\ToolResource\Pages;

use App\Actions\Tool\ToolActions;
use App\Actions\Tool\ToolItemActions;
use App\Enums\ToolStatusEnum;
use App\Filament\Resources\TaskResource;
use App\Filament\Resources\ToolResource;
use App\Models\Task;
use App\Models\Tool;
use Filament\Actions;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Form;
use Filament\Forms;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Filament\Support\Colors\Color;
use Illuminate\Support\HtmlString;

class EditToolModifier extends EditRecord
{
    protected static ?string $navigationLabel = 'Request';
    protected static ?string $title = 'Request';
    protected static ?string $navigationIcon = 'heroicon-m-play';

    protected static string $resource = ToolResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('Run')
//                ->disabled(fn(Tool $record) => !$record->api_id || !$record->file || $record->status !== ToolStatusEnum::CREATED)
                ->icon('heroicon-m-play')
                ->color(Color::Purple)
                ->action(function (Tool $record) {
                    $count = ToolActions::run($record);
                    Notification::make()
                        ->title('Create successfully ' . $count . ' items')
                        ->success()
                        ->send();

                    return null;
                }),
        ];
    }

    public function form(Form $form): Form
    {
        return $form
            ->disabled(false)
            ->schema(function (Tool $record) {
                return [
                    Forms\Components\Placeholder::make('Source Fields')
                        ->content(fn() => new HtmlString(
                            '<p><b>' . join('</b>, <b>', ToolActions::sourceReplacedArgs($record)) . '</b></p>'
                        ))->columnSpan(1),
                    Forms\Components\Placeholder::make('Example')
                        ->content(fn() => new HtmlString('<p>Use this for changes the sources values.<br>
                        <ul>
                            <li><u>Name</u>: <b>full_name</b></li>
                            <li><u>Value</u>: <b>{first_name}</b> <b>{last_name}</b></li>
                        </ul>
                    </p>'))->columnSpan(1),
                    Forms\Components\Repeater::make('settings.' . Tool::SETTING_MODIFIER)
                        ->columnSpanFull()
                        ->nullable()
                        ->default([])
                        ->minItems(0)
                        ->columns(2)
                        ->itemLabel(fn(array $state): ?string => $state['name'] ?? null)
                        ->formatStateUsing(function (?array $state) use ($record) {
                            $state = $state ?? [];
                            $source = ToolActions::sourceReplacedArgs($record);
                            $keys = array_diff(
                                ToolActions::apiRequestArgs($record),
                                array_column($state, 'name')
                            );
                            foreach ($keys as $key) {
                                $value = '{' . $key . '}';
                                if (!in_array($value, $source)) {
                                    $value = '';
                                }
                                $state[] = ['name' => $key, 'value' => $value];
                            }

                            return $state;
                        })
                        ->schema(function () use ($record) {
                            return [
                                Forms\Components\TextInput::make('name')
                                    ->required()->distinct(),
                                Forms\Components\TextInput::make('value')
                                    ->datalist(ToolActions::sourceReplacedArgs($record)),
                            ];
                        })
                        ->deleteAction(
                            fn(Forms\Components\Actions\Action $action) => $action
                                ->disabled(function (Tool $record, array $arguments, Repeater $component) {
                                    if (!isset($arguments['item']) || !is_numeric($arguments['item'])) {
                                        return false;
                                    }
                                    $data = $component->getItemState($arguments['item']);
                                    return in_array(
                                        $data['name'] ?? '',
                                        ToolActions::apiRequestArgs($record)
                                    );
                                }),
                        ),

                ];
            });
    }

    public function getRelationManagers(): array
    {
        return [];
    }

}
