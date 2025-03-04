<?php

namespace App\Filament\Resources;

use App\Actions\Task\TaskActions;
use App\Actions\Task\TaskTimetableActions;
use App\Enums\TaskStateEnum;
use App\Filament\Resources\TaskResource\Pages;
use App\Filament\Resources\TaskResource\Widgets\StatsOverview;
use App\Filament\Resources\TaskResource\Widgets\TaskPlaner;
use App\Filament\Resources\TaskResource\Widgets\TimeTableChart;
use App\Models\Gateway;
use App\Models\Task;
use Filament\Actions\Action;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists;
use Filament\Infolists\Components\Grid;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Navigation\NavigationItem;
use Filament\Notifications\Notification;
use Filament\Pages\SubNavigationPosition;
use Filament\Resources\Resource;
use Filament\Support\Colors\Color;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\HtmlString;
use Filament\Resources\Pages\Page;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class TaskResource extends Resource
{
    protected static ?string $model = Task::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Planner';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),

                Forms\Components\Select::make('gateway_id')
                    ->options(Gateway::all()->pluck('name', 'id'))
                    ->searchable()
                    ->required(),

                Forms\Components\FileUpload::make('file')
                    ->directory(md5(config('app.url')) . '/task/csv')
                    ->disk('local')
                    ->deletable()
                    ->preserveFilenames()
                    ->getUploadedFileNameForStorageUsing(
                        fn(TemporaryUploadedFile $file): string => (string)str(basename($file->getClientOriginalName(), '.csv'))
                            ->slug()
                            ->append('.' . time() . '.csv'),
                    )
                    ->rules([
                        fn(): \Closure => function (string $attribute, $value, \Closure $fail) {
                            /**
                             * @var \Livewire\Features\SupportFileUploads\TemporaryUploadedFile $value
                             */
                            if (pathinfo($value->getClientOriginalName(), \PATHINFO_EXTENSION) !== 'csv') {
                                $fail('Allow only csv files ');
                            }
                        },
                    ])
//                    ->acceptedFileTypes(['text/csv', 'application/csv', 'csv'])
                    ->required(),

                Forms\Components\Select::make('tags')
                    ->multiple()
                    ->relationship(name: 'tags', titleAttribute: 'name')
                    ->searchable(['name'])
                    ->preload(),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('id', 'desc')
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
                TextColumn::make('tags.name')
                    ->badge(),
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
                TextColumn::make('gateway.name')
                    ->badge(),
//                TextColumn::make('file')
//                    ->formatStateUsing(fn(string $state): string => basename($state)),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('tags')
                    ->multiple()
                    ->relationship('tags', 'name')
                    ->searchable('name')
                    ->preload(),
                SelectFilter::make('state')
                    ->options(TaskStateEnum::toArray()),

            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ReplicateAction::make()
                    ->modal(false)
                    ->color(Color::Purple)
                    ->excludeAttributes([
                        'file',
                        'start_at',
                        'jobs_total',
                        'jobs_failed',
                        'jobs_good',
                        'jobs_start_at',
                        'jobs_finish_at',
                        'state',
                    ])
                    ->after(function (Task $record, Task $replica): void {
                        if ($record->tags) {
                            $replica->tags()->attach($record->tags);
                        }
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->requiresConfirmation()
                        ->action(fn(Collection $records) => $records->each(function ($record) {
                            TaskActions::delete($record);
                        })),
                ]),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist->schema([
            Grid::make(1)->schema([
                TextEntry::make('items_min_per_hour')
                    ->label('Min send per hour')
                    ->numeric()
                    ->default(0),

                TextEntry::make('items_max_per_hour')
                    ->label('Max send per hour')
                    ->numeric()
                    ->default(60),
                TextEntry::make('start_at')
                    ->dateTime()
                    ->placeholder('----/--/-- --:--'),
            ])->columnSpan(1),

            Infolists\Components\TextEntry::make('daily_timetable')
                ->formatStateUsing(function (Task $record): HtmlString {
                    return static::viewDailyTimetable($record->daily_timetable);
                })->columnSpan(3),

            Infolists\Components\Actions::make([
                Infolists\Components\Actions\Action::make('Change Settings')
                    ->icon('heroicon-o-clock')
                    ->color(Color::Green)
                    ->fillForm(function (Task $record): array {
                        return $record->toArray();
                    })
                    ->form([
                        Forms\Components\Grid::make(2)->schema([
                            Forms\Components\Group::make([
                                Forms\Components\TextInput::make('items_min_per_hour')
                                    ->required()
                                    ->numeric()
                                    ->default(0),

                                Forms\Components\TextInput::make('items_max_per_hour')
                                    ->minValue(1)
                                    ->required()
                                    ->numeric()
                                    ->default(60),

                                Forms\Components\DateTimePicker::make('start_at')
                                    ->label('Start at')
                                    ->seconds(false)
                                    ->native(false)
                                    ->displayFormat('Y/m/d H:i')
                                    ->nullable()
                                    ->helperText(' (ServerTime: ' . date('c') . ')'),

                            ]),

                            Forms\Components\KeyValue::make('daily_timetable')
                                ->editableKeys(false)
                                ->default(function () {
                                    return array_fill(0, 24, 1);
                                })
                                ->keyLabel('Hour')
                                ->valueLabel('Ratio')
                                ->addable(false)
                                ->deletable(false),

                        ])->columnSpan(1),

                    ])
                    ->action(function (array $data, Task $record) {
                        $record->fill($data);
                        $record->save();

                        $count = TaskTimetableActions::loadOrUpdateSendDate($record);

                        Notification::make()
                            ->title('Update successfully ' . $count . ' items')
                            ->success()
                            ->send();

                        return redirect()->to(static::getUrl('timetable', ['record' => $record]));
                    })
                    ->slideOver(),
            ])->columnSpanFull()->alignRight(),
        ])->columns(4);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getWidgets(): array
    {
        return [
            TimeTableChart::class,
            TaskPlaner::class,
            StatsOverview::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTasks::route('/'),
            'create' => Pages\CreateTask::route('/create'),
            'edit' => Pages\EditTask::route('/{record:id}/edit'),
            'edit-import' => Pages\EditTaskData::route('/{record:id}/edit-import'),
            'timetable' => Pages\ViewTaskTimetable::route('/{record:id}/timetable'),
        ];
    }

    public static function viewDailyTimetable($daily_timetable): HtmlString
    {
        $items = array_chunk($daily_timetable, 12, true);

        $rows = [];

        foreach ($items as $item) {
            $rows[] = '<td class="px-3 py-1.5 align-top">'
                . 'Hour:</td><td class="px-3 py-1.5 align-top">'
                . join('</td><td class="px-3 py-1.5 align-top">', array_keys($item))
                . '</td>';
            $rows[] = '<td class="px-3 py-1.5 align-top">'
                . 'Rate:</td><td class="px-3 py-1.5 align-top">'
                . join('</td><td class="px-3 py-1.5 align-top">', $item)
                . '</td>';
            $rows[] = '<td colspan="100"><hr></td>';
        }

        $html = '
<div class="fi-in-key-value w-full rounded-lg shadow-sm ring-1 bg-white ring-gray-950/5 dark:bg-white/5 dark:ring-white/10">
    <table class="w-full table-auto divide-y divide-gray-200 dark:divide-white/5">
        <tbody class="divide-y divide-gray-200 font-mono text-base dark:divide-white/5 sm:text-sm sm:leading-6">
            <tr class="divide-x divide-gray-200 dark:divide-white/5 rtl:divide-x-reverse">
            ' . join('</tr><tr class="divide-x divide-gray-200 dark:divide-white/5 rtl:divide-x-reverse">', $rows) . '
            </tr>
        </tbody>
    </table>
</div>
        ';

        return new HtmlString($html);
    }

    public static function getRequiredFileKeys(): array
    {
        return [
            'email',
        ];
    }

    public static function getRecordSubNavigation(Page $page): array
    {
        return $page->generateNavigationItems([
            Pages\EditTask::class,
            Pages\EditTaskData::class,
            Pages\ViewTaskTimetable::class,
        ]);
    }

    public static function getSubNavigationPosition(): SubNavigationPosition
    {
        return SubNavigationPosition::Top;
    }

    public static function fileInformation(?Task $task): string
    {
        $information = TaskActions::getFileInformation($task);
        $allow_keys = join('</li><li>', $information['allow_keys']);
        $file_keys = '';

        foreach ($information['file_keys'] as $key) {
            $file_keys .= '<li style="' . (in_array($key, $information['allow_keys']) ? 'color: rgb(var(--success-500))' : '') . '" >' . $key . '</li>';
        }

        $html = '
<div class="fi-in-key-value w-full rounded-lg bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-white/5 dark:ring-white/10">
    <table class="w-full table-auto divide-y divide-gray-200 dark:divide-white/5">
        <thead>
            <tr>
                <th scope="col" class="px-3 py-2 text-start text-sm font-medium text-gray-700 dark:text-gray-200">
                    Keys
                </th>

                <th scope="col" class="px-3 py-2 text-start text-sm font-medium text-gray-700 dark:text-gray-200">
                    File
                </th>
            </tr>
        </thead>

        <tbody class="divide-y divide-gray-200 font-mono text-base dark:divide-white/5 sm:text-sm sm:leading-6">
            <tr class="divide-x divide-gray-200 dark:divide-white/5 rtl:divide-x-reverse">
                <td class="px-3 py-1.5 align-top">
                    <ul><li>' . $allow_keys . '</li></ul>
                </td>
                <td class="px-3 py-1.5 align-top">
                    <ul><li>' . $file_keys . '</li></ul>
                </td>
            </tr>
        </tbody>
    </table>
</div>
';

        return $html;
    }
}
