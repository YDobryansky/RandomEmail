<?php
/**
 * Create: Volodymyr
 */

namespace App\API\ZeroBounce\Activity;

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

class ApiZeroBounceActivity implements ApiInterface
{

    protected DTOZeroBounceActivitySettings $settings;
    protected ResponseInterface $response;

    /**
     * @throws APIException
     */
    public static function send(
        DTOZeroBounceActivitySettings|SettingsInterface $settings,
        DTOZeroBounceActivityRequest|RequestInterface   $request
    ): DTOZeroBounceActivityResponse
    {
        return (new static($settings))
            ->request($request)
            ->response();
    }

    public function __construct(DTOZeroBounceActivitySettings|SettingsInterface $settings)
    {
        $this->settings = $settings;
    }

    /**
     * @throws APIException
     */
    public function request(DTOZeroBounceActivityRequest|RequestInterface $request): static
    {
        if ($request->getApiKey() === null) {
            $request->setApiKey($this->settings->getApiKey());
        }

        if ($request->isEmptyRequiredArgs()) {
            throw NotEnoughDataForRequestException::make(
                join(',', array_keys($request->emptyRequiredArgs()))
            );
        }

        try {
            $this->response = (new Client())
                ->request(
                    'GET',
                    $this->settings->url(),
                    [
                        'query' => $request->toArray(),
                    ]
                );
        } catch (ClientException $e) {
            throw new RequestException($e->getMessage(), $e->getCode(), $e);
        } catch (GuzzleException $e) {
            throw new RemoteException($e->getMessage(), $e->getCode(), $e);
        }
        return $this;
    }

    public function response(): DTOZeroBounceActivityResponse
    {
        return DTOZeroBounceActivityResponse::fromArray(
            json_decode($this->response->getBody(), true)
        );
    }

    public function getResponse(): mixed
    {
        return $this->response;
    }

}
