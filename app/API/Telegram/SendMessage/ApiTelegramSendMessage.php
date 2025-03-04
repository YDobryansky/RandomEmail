<?php
/**
 * Create: Volodymyr
 */

namespace App\API\Telegram\SendMessage;

use App\API\Common\Exceptions\APIException;
use App\API\Common\Exceptions\RemoteException;
use App\API\Common\Exceptions\NotEnoughDataForRequestException;
use App\API\Common\Exceptions\RequestException;
use App\API\Common\Interfaces\ApiInterface;
use App\API\Common\Interfaces\RequestInterface;
use App\API\Common\Interfaces\SettingsInterface;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\ClientException;
use Psr\Http\Message\ResponseInterface;

class ApiTelegramSendMessage implements ApiInterface
{
    protected DTOTelegramSendMessageSettings $settings;
    protected ResponseInterface $response;

    /**
     * @throws APIException
     */
    public static function send(
        DTOTelegramSendMessageSettings|SettingsInterface $settings,
        DTOTelegramSendMessageRequest|RequestInterface   $request
    ): DTOTelegramSendMessageResponse
    {
        return (new static($settings))
            ->request($request)
            ->response();
    }

    public function __construct(DTOTelegramSendMessageSettings|SettingsInterface $settings)
    {
        $this->settings = $settings;
    }

    /**
     * @throws APIException
     */
    public function request(DTOTelegramSendMessageRequest|RequestInterface $request): static
    {
        if (!$request->getChatId()) {
            $request->setChatId($this->settings->getChatId());
        }

        if (!$request->getMessageThreadId()) {
            $request->setMessageThreadId($this->settings->getMessageThreadId());
        }

        if ($request->isEmptyRequiredArgs()) {
            throw NotEnoughDataForRequestException::make(
                join(', ', array_keys($request->emptyRequiredArgs()))
            );
        }

        try {
            $this->response = (new Client())
                ->request('GET', $this->settings->url(), [
                    'query' => $request->toArray(),
                ]);
        } catch (ClientException $e) {
            throw new RequestException($e->getMessage(), $e->getCode(), $e);
        } catch (GuzzleException $e) {
            throw new RemoteException($e->getMessage(), $e->getCode(), $e);
        }

        return $this;
    }

    public function response(): DTOTelegramSendMessageResponse
    {
        return DTOTelegramSendMessageResponse::fromArray(
            json_decode($this->response->getBody(), true)['result']
        );
    }

    public function getResponse(): mixed
    {
        return $this->response;
    }
}
