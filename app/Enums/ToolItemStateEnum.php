<?php
/**
 * Create: Volodymyr
 */

namespace App\Enums;

use Filament\Support\Colors\Color;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum ToolItemStateEnum: int implements HasLabel, HasColor
{
    case CREATE = 0;
    case SUCCESS = 1;
    case ERROR = 2;
    case IN_PROGRESS = 3;

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::CREATE => Color::Blue,
            self::IN_PROGRESS => Color::Orange,
            self::SUCCESS => Color::Green,
            self::ERROR => Color::Red,
        };
    }

    public function getLabel(): ?string
    {
        return $this->name;
    }
}
