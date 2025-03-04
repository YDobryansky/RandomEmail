<?php

namespace NotificationChannels\AbstractDriver;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Arr;
use NotificationChannels\AbstractDriver\Exceptions\CouldNotSendNotification;

abstract class AbstractDriverMessage
{
    protected AbstractDriverApi $api;
    protected string $api_class;
    protected $handle_exception = null;
    protected $handle_send = null;


    public static function create(): static
    {
        return new static();
    }

    /**
     * @throws CouldNotSendNotification
     * @throws \Exception
     */
    abstract public function send(): AbstractDriverRespond;

    public function getApi(): AbstractDriverApi
    {
        if (empty($this->api)) {
            $this->api = new $this->api_class;
        }
        return $this->api;
    }

    public function controll($callback)
    {
        $callback($this);
        return $this;
    }

    /**
     * @return null
     */
    public function getHandleException()
    {
        return $this->handle_exception;
    }

    /**
     * @param null $handle_exception
     * @return static
     */
    public function setHandleException($handle_exception): static
    {
        $this->handle_exception = $handle_exception;
        return $this;
    }

    public function runHandleException($exception): void
    {
        $callable = $this->getHandleException();
        if ($callable) {
            $callable($exception, $this);
        }
    }

    /**
     * @return null
     */
    public function getHandleSend()
    {
        return $this->handle_send;
    }

    /**
     * @param null $handle_send
     * @return static
     */
    public function setHandleSend($handle_send): static
    {
        $this->handle_send = $handle_send;
        return $this;
    }

    public function runHandleSend($response)
    {
        $callable = $this->getHandleSend();
        if ($callable) {
            $callable($response, $this);
        }
    }


}
