<?php

namespace NotificationChannels\OngageNotify\Validation;

use Illuminate\Http\Client\Response;
use NotificationChannels\AbstractDriver\AbstractDriverApi;
use NotificationChannels\AbstractDriver\AbstractDriverMessage;
use NotificationChannels\KyivstarNotify\Exceptions\CouldNotSendNotification;

/**
 * @method OngageValidationApi getApi()
 */
class OngageValidationMessage extends AbstractDriverMessage
{
    protected OngageValidationApi|AbstractDriverApi $api;
    protected string $api_class = OngageValidationApi::class;

    protected $email = null;
    protected int $client_id = 0;

    /**
     * @throws CouldNotSendNotification
     * @throws \Exception
     */
    public function send(): OngageValidationRespond
    {
        $respond = $this->getApi()->realtimeValidation(['email' => $this->getEmail()]);

        return $this->respond($respond);
    }

    /**
     * @throws \NotificationChannels\AbstractDriver\Exceptions\CouldNotSendNotification
     */
    protected function respond(Response $respond): OngageValidationRespond
    {
        return (new OngageValidationRespond($respond));
    }

    /**
     * @return null
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param null $email
     * @return static
     */
    public function setEmail($email): static
    {
        $this->email = $email;
        return $this;
    }

    public function getClientId(): int
    {
        return $this->client_id;
    }

    public function setClientId(int $client_id): static
    {
        $this->client_id = $client_id;
        return $this;
    }

}
