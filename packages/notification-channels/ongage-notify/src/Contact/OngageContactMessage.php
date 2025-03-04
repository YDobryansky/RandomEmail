<?php

namespace NotificationChannels\OngageNotify\Contact;

use Illuminate\Http\Client\Response;
use NotificationChannels\OngageNotify\DTO\OngageApiSettingsDTO;
use NotificationChannels\OngageNotify\OngageApi;

class OngageContactMessage
{
    protected OngageApiSettingsDTO $settings;
    protected OngageContactMessageDTO $message;
    protected OngageApi $api;

    /**
     * @throws \Exception
     */
    public function send(): OngageContactRespondDTO
    {
        $respond = $this->getApi()->addContact($this->getMessage());

        return $this->respond($respond);
    }

    public function getApi(): OngageApi
    {
        if (empty($this->api)) {
            $this->api = (new OngageApi())->setSettings($this->getSettings());
        }
        return $this->api;
    }

    protected function respond(Response $respond): OngageContactRespondDTO
    {
        return (new OngageContactRespondDTO($respond));
    }

    public function getSettings(): OngageApiSettingsDTO
    {
        return $this->settings;
    }

    public function setSettings(OngageApiSettingsDTO $settings): static
    {
        $this->settings = $settings;
        return $this;
    }

    public function getMessage(): OngageContactMessageDTO
    {
        return $this->message;
    }

    public function setMessage(OngageContactMessageDTO $message): static
    {
        $this->message = $message;
        return $this;
    }


}
