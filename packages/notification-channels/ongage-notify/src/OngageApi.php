<?php
/**
 * Create: Vladimir
 */

namespace NotificationChannels\OngageNotify;

use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Client\Factory as HttpClient;
use Illuminate\Http\Client\Response;
use NotificationChannels\OngageNotify\DTO\OngageApiSettingsDTO;

class OngageApi
{

    protected OngageApiSettingsDTO $settings;

    protected string $url_contact = 'contacts';
    protected HttpClient $http_client;

    public function __construct()
    {
        $this->setHttpClient(new HttpClient());
    }

    protected function options(): array
    {
        return [
            'headers' => [
                'Content-Type' => 'application/json',
                'X_USERNAME' => $this->getSettings()->getLogin(),
                'X_PASSWORD' => $this->getSettings()->getPassword(),
                'X_ACCOUNT_CODE' => $this->getSettings()->getAccountCode(),
            ],
        ];
    }

    /**
     * @param array $message = { "email": "email2@example.com", "first_name": "testName", "phone": 123456789, "country": "Ukraine" }
     * @return PromiseInterface|Response
     * @throws \Exception
     */
    public function addContact(mixed $message): PromiseInterface|Response
    {
        $options = $this->options();

        $options['json'] = $message;

        return $this->getHttpClient()
            ->send('POST', $this->url($this->url_contact), $options);
    }

    /**
     * Load contacts list
     */
    public function listContacts(int $page = 1, int $limit = 500): array
    {
        $options = $this->options();
        $options['query'] = [
            'page' => $page,
            'limit' => $limit,
        ];

        $response = $this->getHttpClient()
            ->send('GET', $this->url($this->url_contact), $options);

        return $response->json('payload.contacts') ?? [];
    }

    /**
     * Get contact activity
     */
    public function getContactHistory(string|int $contactId): array
    {
        $options = $this->options();

        $response = $this->getHttpClient()
            ->send('GET', $this->url($this->url_contact . '/' . $contactId . '/history'), $options);

        return $response->json('payload') ?? [];
    }

    public function url($url)
    {
        return rtrim($this->getSettings()->getBaseUrl(), '/')
            . '/' . ltrim($url, '/');
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

    public function getHttpClient(): HttpClient
    {
        return $this->http_client;
    }

    public function setHttpClient(HttpClient $http_client): static
    {
        $this->http_client = $http_client;
        return $this;
    }

}
