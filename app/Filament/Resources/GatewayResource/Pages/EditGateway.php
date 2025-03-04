<?php

namespace App\Filament\Resources\GatewayResource\Pages;

use App\Filament\Resources\GatewayResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditGateway extends EditRecord
{
    protected static string $resource = GatewayResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    public function getFooterWidgetsColumns(): int|string|array
    {
        return 1;
    }

    protected function getFooterWidgets(): array
    {
        return [
            GatewayResource\Widgets\StatisticUsed::class
        ];
    }
}
