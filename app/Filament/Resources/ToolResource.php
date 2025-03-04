<?php

namespace App\Filament\Resources;

use App\Enums\ToolStatusEnum;
use App\Filament\Resources\ToolResource\Pages;
use App\Models\Tool;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Pages\Page;
use Filament\Pages\SubNavigationPosition;
use Filament\Resources\Resource;
use Filament\Support\Colors\Color;
use Filament\Tables;
use Filament\Tables\Table;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class ToolResource extends Resource
{
    protected static ?string $model = Tool::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Tools';

    public static function form(Form $form): Form
    {
        return $form
            ->disabled(function (Tool $resource) {
                return $resource->status !== ToolStatusEnum::CREATED and $resource->status !== null;
            })
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->default('Create at ' . date('Y-m-d'))
                    ->required(),
                Forms\Components\TextInput::make('items_per_step')
                    ->default(100)
                    ->numeric(),
                Forms\Components\Select::make('api_id')
                    ->required()
                    ->preload()
                    ->relationship('api', 'name'),
                Forms\Components\FileUpload::make('file')
                    ->directory(md5(config('app.url')) . '/tool/csv')
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
                    ->label('File')
                    ->required(),
                Forms\Components\Hidden::make('settings')
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('id', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->sortable(),
                Tables\Columns\TextColumn::make('api.name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('items_per_step')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('items_total')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('items_error')
                    ->color(Color::Red)
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('items_success')
                    ->color(Color::Green)
                    ->numeric()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
//                Tables\Actions\BulkActionGroup::make([
//                    Tables\Actions\DeleteBulkAction::make(),
//                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            ToolResource\RelationManagers\ItemsRelationManager::class,
            //ToolResource::getRelations(),
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTools::route('/'),
            'create' => Pages\CreateTool::route('/create'),
            'edit' => Pages\EditTool::route('/{record}/edit'),
            'modifier' => Pages\EditToolModifier::route('/{record}/modifier'),
            'export' => Pages\EditToolExport::route('/{record}/export'),
        ];
    }

    public static function getRecordSubNavigation(Page $page): array
    {
        return $page->generateNavigationItems([
            Pages\EditTool::class,
            Pages\EditToolModifier::class,
            Pages\EditToolExport::class,
        ]);
    }

    public static function getSubNavigationPosition(): SubNavigationPosition
    {
        return SubNavigationPosition::Top;
    }

}
