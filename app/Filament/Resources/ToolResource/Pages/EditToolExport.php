<?php

namespace App\Filament\Resources\ToolResource\Pages;

use App\Actions\Tool\ToolActions;
use App\Actions\Tool\ToolItemActions;
use App\Enums\ToolStatusEnum;
use App\Filament\Resources\TaskResource;
use App\Filament\Resources\ToolResource;
use App\Models\Task;
use App\Models\Tool;
use App\Models\ToolItem;
use Filament\Actions;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Form;
use Filament\Forms;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Filament\Support\Colors\Color;
use Illuminate\Support\HtmlString;

class EditToolExport extends EditRecord
{
    protected static ?string $navigationLabel = 'Export';
    protected static ?string $title = 'Export';

    protected static ?string $navigationIcon = 'heroicon-o-document-arrow-up';

    protected static string $resource = ToolResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('Export')
                ->disabled(fn(Tool $record) => $record->status !== ToolStatusEnum::FINISHED)
                ->icon('heroicon-o-document-arrow-up')
                ->color(Color::Orange)
                ->action(function (Tool $record) {
                    return ToolItemActions::exportFromTool($record);
                }),
        ];
    }


    public function form(Form $form): Form
    {
        return $form
            ->disabled(false)
            ->schema(function (Tool $record) {

                $options = [
                    'record' => [
                        'state' => 'State',
                        'id' => 'ID',
                    ],
                    ToolItem::SOURCE => [],
                    ToolItem::RESULT => [],
                ];

                foreach (ToolActions::sourceArgs($record) as $key) {
                    $options[ToolItem::SOURCE][ToolItem::SOURCE . '.' . $key] = $key;
                }

                foreach (ToolActions::responseArgs($record) as $key) {
                    $options[ToolItem::RESULT][ToolItem::RESULT . '.' . $key] = $key;
                }

                return [
                    Forms\Components\Select::make('settings.export')
                        ->columnSpanFull()
                        ->multiple()
                        ->searchable()
                        ->preload()
                        ->options($options),

                ];
            });
    }

}
