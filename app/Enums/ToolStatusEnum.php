<?php
/**
 * Create: Volodymyr
 */

namespace App\Enums;

use Filament\Support\Colors\Color;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum ToolStatusEnum: int implements HasLabel, HasColor
{
    case CREATED = 0;
    case STARTED = 1;
    case IN_PROGRESS = 2;
    case FINISHED = 3;

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::CREATED => Color::Blue,
            self::STARTED => Color::Gray,
            self::IN_PROGRESS => Color::Orange,
            self::FINISHED => Color::Green,
        };
    }

    public function getLabel(): ?string
    {
        return $this->name;
    }
}
