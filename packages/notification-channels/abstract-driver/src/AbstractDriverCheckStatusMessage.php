<?php

namespace NotificationChannels\AbstractDriver;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Arr;
use NotificationChannels\AbstractDriver\Exceptions\CouldNotSendNotification;

abstract class AbstractDriverCheckStatusMessage extends AbstractDriverMessage
{
    protected string $external_id;
    /**
     * @note add code $this->api = new AbstractDriverCheckStatusRespond($respond);
     */
    protected string $respond_class;

    /**
     * @throws CouldNotSendNotification
     * @throws \Exception
     */
    public function send(): AbstractDriverRespond
    {
        $respond = $this->getApi()->checkStatus($this->getExternalId());

        return $this->respond($respond);
    }

    protected function respond(Response $respond): AbstractDriverRespond
    {
        return new $this->respond_class($respond);
    }

    /**
     * @return string
     */
    public function getExternalId(): string
    {
        return $this->external_id;
    }

    /**
     * @param string $external_id
     * @return static
     */
    public function setExternalId(string $external_id): static
    {
        $this->external_id = $external_id;
        return $this;
    }

}
