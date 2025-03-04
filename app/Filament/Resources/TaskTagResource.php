<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TaskTagResource\Pages;
use App\Filament\Resources\TaskTagResource\RelationManagers;
use App\Models\TaskTag;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TaskTagResource extends Resource
{
    protected static ?string $model = TaskTag::class;

    protected static ?string $navigationIcon = 'heroicon-c-tag';
    protected static ?string $navigationGroup = 'Planner';
    protected static ?string $navigationLabel = 'Tags';
    protected static ?string $pluralModelLabel = 'Tags';
    protected static ?string $label = 'Tag';
    protected static ?int $navigationSort = 5;


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->columnSpanFull()
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTaskTags::route('/'),
            'create' => Pages\CreateTaskTag::route('/create'),
            'edit' => Pages\EditTaskTag::route('/{record}/edit'),
        ];
    }
}
