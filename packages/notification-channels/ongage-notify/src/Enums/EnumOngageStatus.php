<?php
/**
 * Create: Vladimir
 */

namespace NotificationChannels\OngageNotify\Enums;

use NotificationChannels\AbstractDriver\Enums\EnumAbstractChannelStatus;

class EnumOngageStatus extends EnumAbstractChannelStatus
{
    const ERROR_400 = 1;
    const ERROR_404 = 2;
    const ERROR_412 = 3;
    const ERROR_500 = 4;

    protected static array $extend = [
        self::ERROR_400 => ['name' => 'Invalid data in request'],
        self::ERROR_404 => ['name' => 'List not found'],
        self::ERROR_412 => ['name' => 'Invalid data in request'],
        self::ERROR_500 => ['name' => 'General error'],
    ];

}
