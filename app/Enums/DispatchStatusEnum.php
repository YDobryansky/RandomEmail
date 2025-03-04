<?php

namespace App\Enums;

enum DispatchStatusEnum: int
{
    case Create = 1;
    case Sent = 2;
    case Error = 3;
    case Prepare = 4;

    public static function valueName(): array
    {
        $values = [];
        foreach (self::cases() as $case) {
            $values[$case->value] = $case->name;
        }
        return $values;
    }

}
