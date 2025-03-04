<?php

namespace App\Filament\Resources\ToolResource\RelationManagers;

use App\Models\ToolItem;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\HtmlString;

class ItemsRelationManager extends RelationManager
{
    protected static string $relationship = 'items';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('id')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->poll('30s')
            ->defaultSort('id', 'desc')
            ->recordTitleAttribute('id')
            ->columns([
                Tables\Columns\TextColumn::make('state')->badge(),
                Tables\Columns\TextColumn::make('value')
                    ->state(1)
                    ->formatStateUsing(fn(ToolItem $record): HtmlString => new HtmlString(
                        '<pre>' . json_encode(
                            $record->values[ToolItem::SOURCE] ?? [],
                            JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
                        ) . '</pre>'
                    )),
                Tables\Columns\TextColumn::make('result')
                    ->state(1)
                    ->formatStateUsing(fn(ToolItem $record): HtmlString => new HtmlString(
                        '<pre>' . json_encode(
                            $record->values[ToolItem::RESULT] ?? [],
                            JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
                        ) . '</pre>'
                    )),
//                Tables\Columns\TextColumn::make('values')
//                    ->formatStateUsing(fn (string $state): HtmlString => new HtmlString('123')),
            ])
            ->filters([
                //
            ])
            ->headerActions([
//                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
//                Tables\Actions\EditAction::make(),
//                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
//                Tables\Actions\BulkActionGroup::make([
//                    Tables\Actions\DeleteBulkAction::make(),
//                ]),
            ]);
    }
}
