<?php

namespace NotificationChannels\OngageNotify\Validation;

use Illuminate\Notifications\Notification;
use NotificationChannels\AbstractDriver\AbstractDriverChannel;
use NotificationChannels\AbstractDriver\AbstractDriverMessage;

class OngageValidationChannel extends AbstractDriverChannel
{
    protected string $channel = \NotificationChannels\OngageNotify\OngageServiceProvider::CHANNEL;

    protected function getMessage(mixed $notifiable, Notification $notification): AbstractDriverMessage
    {
        return $notification->toOngageValidation($notifiable);
    }

}
