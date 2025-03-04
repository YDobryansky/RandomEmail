<?php

namespace NotificationChannels\OngageNotify\Contact;

use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Notifications\Events\NotificationFailed;
use Illuminate\Notifications\Notification;
use NotificationChannels\OngageNotify\OngageServiceProvider;

class OngageContactChannel
{
    /**
     * @var Dispatcher
     */
    protected Dispatcher $dispatcher;
    protected string $channel = OngageServiceProvider::CHANNEL;

    /**
     * Channel constructor.
     */
    public function __construct(Dispatcher $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    protected function getMessage(mixed $notifiable, Notification $notification): OngageContactMessage
    {
        return $notification->toOngageContact($notifiable);
    }

    /**
     * Send the given notification.
     *
     * @param mixed $notifiable
     * @param Notification $notification
     *
     * @return mixed
     * @throws \Exception
     */
    public function send(mixed $notifiable, Notification $notification): mixed
    {
        $message = $this->getMessage($notifiable, $notification);

        try {
            $response = $message->send();
        } catch (\Exception $exception) {
            $this->dispatcher->dispatch(
                new NotificationFailed($notifiable, $notification, $this->channel, [
                    'message' => $message,
                    'exception' => $exception,
                ]),
            );

            throw $exception;
        }

        return $response;
    }
}
