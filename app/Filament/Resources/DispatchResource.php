<?php

namespace App\Filament\Resources;

use App\Actions\DispatchActions;
use App\Enums\DispatchStatusEnum;
use App\Filament\Resources\DispatchResource\Pages;
use App\Models\Dispatch;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

use Filament\Infolists;
use Filament\Infolists\Infolist;

class DispatchResource extends Resource
{
    protected static ?string $model = Dispatch::class;

    protected static ?string $navigationIcon = 'heroicon-m-cloud-arrow-up';
    protected static ?string $navigationGroup = 'Planner';
    protected static ?int $navigationSort = 1;
    protected static ?string $navigationLabel = 'Jobs';
    protected static ?string $pluralModelLabel = 'Jobs';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\DateTimePicker::make('send_date')
                    ->required(),
                Forms\Components\Toggle::make('send_status')
                    ->required(),
                Forms\Components\TextInput::make('gateway_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('task_id')
                    ->required()
                    ->numeric(),
                Forms\Components\Textarea::make('data')
                    ->required()
                    ->maxLength(65535)
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('send_date', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('task.name')->sortable(),
                Tables\Columns\TextColumn::make('gateway.name'),
                Tables\Columns\TextColumn::make('send_status')->sortable()
                    ->state(function (Model $record) {
                        return DispatchStatusEnum::from($record->send_status)->name;
                    }),
                Tables\Columns\TextColumn::make('send_date')
                    ->dateTime('c')
                    ->sortable(),
//                Tables\Columns\TextColumn::make('data')
//                    ->html(true)
//                    ->state(function (Model $record) {
//                        return '<pre>' .
//                            json_encode(
//                                $record->data,
//                                JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
//                            )
//                            . '</pre>';
//                    }),
            ])
            ->filters([
                SelectFilter::make('task')
                    ->relationship('task', 'name'),
                SelectFilter::make('gateway')
                    ->relationship('gateway', 'name'),
                SelectFilter::make('send_status')->label('Status')
                    ->options(DispatchStatusEnum::valueName()),
                //
            ])
            ->actions([
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\ViewAction::make(),
//                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('Send')
                    ->icon('heroicon-o-play')
                    ->action(function (Dispatch $record) {
                        DispatchActions::send($record);
                        $record->refresh();
                        Notification::make()
                            ->title('Job Sent')
                            ->success()
                            ->send();
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }


    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\TextEntry::make('id'),
                Infolists\Components\TextEntry::make('gateway.name'),
                Infolists\Components\TextEntry::make('data')
                    ->html()
                    ->state(function (Model $record) {
                        return '<pre>' .
                            json_encode(
                                $record->data,
                                JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
                            )
                            . '</pre>';
                    })
                    ->columnSpanFull(),
                Infolists\Components\TextEntry::make('history')
                    ->html()
                    ->state(function (Model $record) {
                        $histories = $record->history->map(function ($history) {
                            return
                                '<div>' . $history->key . '</div>' .
                                '<pre>' . $history->value . '</pre>';
                        });

                        return $histories->join('');
                    })
                    ->columnSpanFull()
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDispatches::route('/'),
//            'create' => Pages\CreateDispatch::route('/create'),
            'view' => Pages\ViewDispatch::route('/{record}'),
//            'edit' => Pages\EditDispatch::route('/{record}/edit'),
        ];
    }
}
