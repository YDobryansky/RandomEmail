<?php

namespace NotificationChannels\AbstractDriver;

use Illuminate\Notifications\Notification;

abstract class AbstractDriverCheckStatusChannel extends AbstractDriverChannel
{

    protected function getMessage(mixed $notifiable, Notification $notification): AbstractDriverMessage
    {
        $this->channel = AbstractDriverServiceProvider::CHANNEL;
        // @phpstan-ignore-next-line
        return $notification->toAbstractDriverSmsCheckStatus($notifiable);
    }
}
