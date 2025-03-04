<?php

namespace App\Filament\Resources\ToolResource\Pages;

use App\Actions\Tool\ToolActions;
use App\Actions\Tool\ToolItemActions;
use App\Enums\ToolStatusEnum;
use App\Filament\Resources\ToolResource;
use App\Models\Tool;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Filament\Support\Colors\Color;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Blade;

class EditTool extends EditRecord
{
    protected static string $resource = ToolResource::class;

    protected static ?string $title = 'Edit';
    protected static ?string $navigationLabel = 'Edit';

    protected static ?string $navigationIcon = 'heroicon-o-pencil-square';

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('Delete')
                ->color(Color::Red)
                ->icon('heroicon-m-trash')
                ->requiresConfirmation()
                ->action(function (Tool $record) {
                    $result = ToolActions::delete($record);
                    if ($result) {
                        return redirect()->to(ToolResource::getUrl('index'));
                    } else {
                        return Notification::make('Error')
                            ->danger()
                            ->body('Cannot delete this tool')
                            ->send();
                    }
                }),

        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        if (
            $this->record->file !== $data['file']
            || $this->record->api_id !== $data['api_id']
        ) {
            $this->record->settings = [];
        }

        return $data;
    }

    public function getRelationManagers(): array
    {
        return [];
    }
}
