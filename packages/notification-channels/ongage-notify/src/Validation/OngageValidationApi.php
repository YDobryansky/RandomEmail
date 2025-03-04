<?php
/**
 * Create: Vladimir
 */

namespace NotificationChannels\OngageNotify\Validation;

use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Client\Response;
use NotificationChannels\AbstractDriver\AbstractDriverApi;

class OngageValidationApi extends AbstractDriverApi
{
    protected string $base_url = 'https://api.ongage.io/email-validation/api/v1/';
    protected string $url_realtime_validation = 'realtime-validation';

    protected function options(): array
    {
        return [
            'headers' => [
                'Content-Type' => 'application/json',
                'x-api-key' => $this->getPassword(),
            ],
        ];
    }

    /**
     * @param array $message = ("email":"email@email.com"}
     * @return PromiseInterface|Response
     * @throws \Exception
     */
    public function realtimeValidation(mixed $message): PromiseInterface|Response
    {
        $options = $this->options();

        $options['json'] = $message;

        return $this->getHttpClient()
            ->send('POST', $this->url($this->url_realtime_validation), $options);
    }

}
