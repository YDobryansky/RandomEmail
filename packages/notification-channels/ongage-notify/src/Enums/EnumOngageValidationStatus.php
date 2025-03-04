<?php
/**
 * Create: Vladimir
 */

namespace NotificationChannels\OngageNotify\Enums;

use NotificationChannels\AbstractDriver\Enums\EnumAbstractChannelStatus;

class EnumOngageValidationStatus extends EnumAbstractChannelStatus
{
    const DELIVERABLE = 1;
    const RISKY = 2;
    const UNDELIVERABLE = 3;

    protected static array $extend = [
        self::UNKNOWN => ['name' => 'Unknown State'],
        self::DELIVERABLE => ['name' => 'Deliverable'],
        self::RISKY => ['name' => 'Risky'],
        self::UNDELIVERABLE => ['name' => 'Undeliverable'],
    ];

}
