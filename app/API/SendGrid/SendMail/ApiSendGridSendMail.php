<?php
namespace App\API\SendGrid\SendMail;

use App\API\Common\Exceptions\APIException;
use App\API\Common\Exceptions\NotEnoughDataForRequestException;
use App\API\Common\Exceptions\RemoteException;
use App\API\Common\Exceptions\RequestException;
use App\API\Common\Interfaces\ApiInterface;
use App\API\Common\Interfaces\RequestInterface;
use App\API\Common\Interfaces\SettingsInterface;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;

class ApiSendGridSendMail implements ApiInterface
{
    protected DTOSendGridSendMailSettings $settings;
    protected ResponseInterface $response;

    /**
     * @throws APIException
     */
    public static function send(
        DTOSendGridSendMailSettings|SettingsInterface $settings,
        DTOSendGridSendMailRequest|RequestInterface   $request
    ): DTOSendGridSendMailResponse {
        return (new static($settings))
            ->request($request)
            ->response();
    }

    public function __construct(DTOSendGridSendMailSettings|SettingsInterface $settings)
    {
        $this->settings = $settings;
    }

    /**
     * @throws APIException
     */
    public function request(DTOSendGridSendMailRequest|RequestInterface $request): static
    {
        if ($request->isEmptyRequiredArgs()) {
            throw NotEnoughDataForRequestException::make(
                join(', ', array_keys($request->emptyRequiredArgs()))
            );
        }

        $payload = [
            'personalizations' => [
                [
                    'to' => [
                        ['email' => $request->getToEmail(), 'name' => $request->getToName()],
                    ],
                    'subject' => $request->getSubject(),
                ],
            ],
            'from' => [
                'email' => $request->getFromEmail(),
                'name' => $request->getFromName(),
            ],
            'content' => [
                [
                    'type' => 'text/plain',
                    'value' => $request->getText(),
                ],
            ],
        ];

        try {
            $this->response = (new Client())->request('POST', $this->settings->url(), [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->settings->getApiKey(),
                    'Content-Type' => 'application/json',
                ],
                'json' => $payload,
            ]);
        } catch (ClientException $e) {
            throw new RequestException($e->getMessage(), $e->getCode(), $e);
        } catch (GuzzleException $e) {
            throw new RemoteException($e->getMessage(), $e->getCode(), $e);
        }

        return $this;
    }

    public function response(): DTOSendGridSendMailResponse
    {
        return DTOSendGridSendMailResponse::fromArray([
            'message_id' => $this->response->getHeaderLine('X-Message-Id'),
        ]);
    }

    public function getResponse(): mixed
    {
        return $this->response;
    }
}
