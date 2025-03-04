<?php

namespace NotificationChannels\AbstractDriver;

use Illuminate\Http\Client\Response;

abstract class AbstractDriverSmsMessage extends AbstractDriverMessage
{
    protected string $to;
    protected string $from;
    protected string $message;

    /**
     * @return string
     */
    public function getTo(): string
    {
        return $this->to;
    }

    /**
     * @param string $to
     * @return static
     */
    public function setTo(string $to): static
    {
        $this->to = $to;
        return $this;
    }

    /**
     * @return string
     */
    public function getFrom(): string
    {
        return $this->from;
    }

    /**
     * @param string $from
     * @return static
     */
    public function setFrom(string $from): static
    {
        $this->from = $from;
        return $this;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @param string $message
     * @return static
     */
    public function setMessage(string $message): static
    {
        $this->message = $message;
        return $this;
    }

}
