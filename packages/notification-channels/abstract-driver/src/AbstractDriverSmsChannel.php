<?php

namespace NotificationChannels\AbstractDriver;

use Illuminate\Notifications\Notification;

abstract class AbstractDriverSmsChannel extends AbstractDriverChannel
{
    protected string $channel = AbstractDriverServiceProvider::CHANNEL;

    protected function getMessage(mixed $notifiable, Notification $notification): AbstractDriverMessage
    {
        // @phpstan-ignore-next-line
        return $notification->toAbstractDriverSms($notifiable);
    }

}
