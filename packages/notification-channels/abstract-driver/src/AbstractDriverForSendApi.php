<?php
/**
 * Create: Vladimir
 */

namespace NotificationChannels\AbstractDriver;

use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Client\Response;

abstract class AbstractDriverForSendApi extends AbstractDriverApi
{
    protected string $url_send_sms = '';
    protected string $url_check_status = '';


    /**
     * @param array $message = {"source": "%from%", "destination": "%to%", "content": "%message%", "serviceType": "..."}
     * @return PromiseInterface|Response
     * @throws \Exception
     */
    public function sendSms(mixed $message): PromiseInterface|Response
    {
        $options = $this->options();

        $options['json'] = $message;

        return $this->getHttpClient()
            ->send('POST', $this->url($this->url_send_sms), $options);
    }

    /**
     * @throws \Exception
     */
    public function checkStatus($external_id): PromiseInterface|Response
    {
        return $this->getHttpClient()
            ->send('GET', $this->url([$this->url_check_status, $external_id]), $this->options());
    }


}
