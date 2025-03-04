<?php

namespace NotificationChannels\AbstractDriver\Exceptions;

use Illuminate\Http\Client\Response;

class CouldNotSendNotification extends \Exception
{
    protected Response $response;
    public static function fromResponse(Response $response, $subject = ''): static
    {
        $self = new static(
            static::class . ' ' . $subject . ' : ' . $response->status() . ' / ' . $response->reason(),
            $response->status()
        );

        $self->response = $response;

        return $self;
    }

    public function getResponse(): Response
    {
        return $this->response;
    }

}
