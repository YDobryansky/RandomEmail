<?php

namespace App\Filament\Resources;

use App\API\Common\Interfaces\ServiceInterface;
use App\Enums\ApiEnum;
use App\Filament\Resources\ApiResource\Pages;
use App\Filament\Resources\ApiResource\RelationManagers;
use App\Models\Api;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ApiResource extends Resource
{
	protected static ?string $model = Api::class;

	protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Tools';

	public static function form(Form $form): Form
	{
		return $form
			->schema([
				Forms\Components\TextInput::make('name')
					->required()
					->maxLength(255),
				Forms\Components\Select::make('driver')
					->options(ApiEnum::class)
					->live()
					->required(),
				Forms\Components\Fieldset::make('settings')
					->schema(function (Get $get) {
                        /**
                         * @var null|ServiceInterface $driver
                         */
						$driver = $get('driver');
						return $driver ? $driver::getSettingsForm() : [];
					}),
			]);
	}

	public static function table(Table $table): Table
	{
		return $table
			->columns([
				Tables\Columns\TextColumn::make('name')
					->searchable(),
				Tables\Columns\TextColumn::make('driver')
					->searchable(),
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
			'index' => Pages\ListApis::route('/'),
			'create' => Pages\CreateApi::route('/create'),
			'edit' => Pages\EditApi::route('/{record}/edit'),
		];
	}
}
