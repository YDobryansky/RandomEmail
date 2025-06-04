<?php

namespace App\Enums;

enum GatewayTypeEnum: string
{
    case Ongage = 'ongage';
    case Telegram = 'telegram';

    public static function valueName(): array
    {
        $values = [];
        foreach (self::cases() as $case) {
            $values[$case->value] = $case->name;
        }
        return $values;
    }

}
