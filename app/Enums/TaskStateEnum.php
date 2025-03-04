<?php
/**
 * Create: Volodymyr
 */

namespace App\Enums;

use Filament\Support\Colors\Color;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum TaskStateEnum: int implements HasLabel, HasColor
{
    case CREATED = 0;
    case WAITING = 1;
    case PROGRESS = 2;
    case FINISHED = 3;
    case TERMINATED = 4;

    static function toArray()
    {
        return [
            self::CREATED->value => 'Created',
            self::WAITING->value => 'Waiting',
            self::PROGRESS->value => 'Progress',
            self::FINISHED->value => 'Finished',
            self::TERMINATED->value => 'Terminated',
        ];
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::CREATED => Color::Blue,
            self::WAITING => Color::Gray,
            self::PROGRESS => Color::Orange,
            self::FINISHED => Color::Green,
            self::TERMINATED => Color::Red,
        };
    }

    public function getLabel(): ?string
    {
        return $this->name;
    }

}
