<?php
/**
 * Create: Vladimir
 */

namespace NotificationChannels\AbstractDriver;

use Illuminate\Http\Client\Response;
use NotificationChannels\AbstractDriver\Exceptions\CouldNotSendNotification;

abstract class AbstractDriverRespond implements \JsonSerializable
{
    protected Response $response;

    /**
     * @throws CouldNotSendNotification
     */
    public function __construct(Response $response)// отримувач
    {
        $this->setResponse($response);

        if ($response->successful()) {
            $this->parseResponse();
        } else {
            $this->errorResponse();
        }
    }

    /**
     * @throws CouldNotSendNotification
     */
    protected function errorResponse()
    {
        throw CouldNotSendNotification::fromResponse($this->getResponse(), static::class);
    }

    abstract protected function parseResponse();

    /**
     * @return Response
     */
    public function getResponse(): Response
    {
        return $this->response;
    }

    /**
     * @param Response $response
     * @return static
     */
    public function setResponse(Response $response): static
    {
        $this->response = $response;
        return $this;
    }


    public function jsonSerialize(): array
    {
        return [];
    }

}
