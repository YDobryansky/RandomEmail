<?php

namespace App\Filament\Resources;

use App\Filament\Resources\JobResource\Pages;
use App\Models\Job;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class JobResource extends Resource
{
    protected static ?string $model = Job::class;
    protected static bool $isDiscovered = false;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Planner';
    protected static ?int $navigationSort = 4;
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('queue')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('payload')
                    ->required()
                    ->rows(10)
                    ->columnSpanFull(),
                Forms\Components\Toggle::make('attempts')
                    ->required(),
                Forms\Components\TextInput::make('reserved_at')
                    ->numeric(),
                Forms\Components\TextInput::make('available_at')
                    ->required()
                    ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('payload')
                    ->state(function (Model $record) {
                        $payload = json_decode($record->payload, true);
                        $command = unserialize($payload['data']['command']);
                        $info = [
                            'name' => $payload['displayName'],
                            'user' => $command->notifiables[0]->jsonSerialize(),
                            'delay' => (string)$command->notification->delay,
                        ];
                        return '<pre>' .
                                json_encode(
                                    $info,
                                    JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
                                )
                            . '</pre>';
                    })->html(true),
                Tables\Columns\TextColumn::make('queue'),
                Tables\Columns\IconColumn::make('attempts')
                    ->boolean(),
                Tables\Columns\TextColumn::make('reserved_at')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('available_at')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            'index' => Pages\ListJobs::route('/'),
            'view' => Pages\ViewJob::route('/{record}'),
        ];
    }
}
