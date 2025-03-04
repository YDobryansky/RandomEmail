<?php

namespace App\Filament\Resources\TaskTagResource\Pages;

use App\Filament\Resources\TaskTagResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateTaskTag extends CreateRecord
{
    protected static string $resource = TaskTagResource::class;
}
