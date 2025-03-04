<?php
/**
 * Create: Vladimir
 */

namespace NotificationChannels\AbstractDriver;

use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Notifications\Events\NotificationFailed;
use Illuminate\Notifications\Notification;

abstract class AbstractDriverChannel
{
    /**
     * @var Dispatcher
     */
    protected Dispatcher $dispatcher;
    protected string $channel;

    /**
     * Channel constructor.
     */
    public function __construct(Dispatcher $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    abstract protected function getMessage(mixed $notifiable, Notification $notification): AbstractDriverMessage;

    /**
     * Send the given notification.
     *
     * @param mixed $notifiable
     * @param Notification $notification
     *
     * @return mixed|AbstractDriverCheckStatusRespond
     * @throws \Exception
     */
    public function send(mixed $notifiable, Notification $notification): mixed
    {
        $message = $this->getMessage($notifiable, $notification);

        try {
            $response = $message->send();
            $message->runHandleSend($response);
        } catch (\Exception $exception) {
            $this->dispatcher->dispatch(
                new NotificationFailed($notifiable, $notification, $this->channel, [
                    'message' => $message,
                    'exception' => $exception,
                ]));

            $message->runHandleException($exception);

            throw $exception;
        }

        return $response;
    }
}
