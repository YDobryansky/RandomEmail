<?php

namespace App\Filament\Resources;

use App\Enums\GatewayTypeEnum;
use App\Filament\Resources\GatewayResource\Pages;
use App\Filament\Resources\GatewayResource\Widgets\StatisticUsed;
use App\Models\Gateway;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class GatewayResource extends Resource
{
    protected static ?string $model = Gateway::class;

    protected static ?string $navigationIcon = 'heroicon-c-link';

    protected static ?string $navigationGroup = 'Planner';
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Toggle::make('state')
                    ->default(1)
                    ->inline(false)
                    ->required(),
                Forms\Components\Select::make('type')
                    ->required()
                    ->options(GatewayTypeEnum::valueName())
                    ->default(array_key_first(GatewayTypeEnum::valueName())),
                Forms\Components\KeyValue::make('settings')
                    ->default(function () {
                        return [
                            'url' => 'https://api.ongage.net/{list_id}/api/v2',
                            'login' => '',
                            'password' => '',
                            'list_id' => '',
                            'account_code' => '',
                        ];
                    })->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\IconColumn::make('state')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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

    public static function getWidgets(): array
    {
        return [
            StatisticUsed::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListGateways::route('/'),
            'create' => Pages\CreateGateway::route('/create'),
            'edit' => Pages\EditGateway::route('/{record}/edit'),
        ];
    }
}
