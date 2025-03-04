<?php
/**
 * Create: Vladimir
 */

namespace NotificationChannels\AbstractDriver;

use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Client\Factory as HttpClient;
use Illuminate\Http\Client\Response;

abstract class AbstractDriverApi
{
    protected string $user_name;
    protected string $password;
    protected string $base_url = '';
    protected ?HttpClient $http_client;

    public function __construct()
    {
        $this->setHttpClient(new HttpClient());
    }

    protected function options(): array
    {
        return [];
    }

    public function url(string|array|null $key = null): string
    {
        if (is_array($key)) {
            $key = implode('/', $key);
        }
        $key = trim($key, '/');
        if ($key) {
            $key = '/' . $key;
        }

        return $this->getBaseUrl() . $key;
    }

    /**
     * @return string
     */
    public function getUserName(): string
    {
        return $this->user_name;
    }

    /**
     * @param string $user_name
     * @return static
     */
    public function setUserName(string $user_name): static
    {
        $this->user_name = $user_name;
        return $this;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     * @return static
     */
    public function setPassword(string $password): static
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @return string
     */
    public function getBaseUrl(): string
    {
        return $this->base_url;
    }

    /**
     * @param string $base_url
     * @return static
     */
    public function setBaseUrl(string $base_url): static
    {
        $this->base_url = $base_url;
        return $this;
    }

    /**
     * @return HttpClient
     */
    public function getHttpClient(): HttpClient
    {
        return $this->http_client;
    }

    /**
     * @param HttpClient $http_client
     * @return static
     */
    public function setHttpClient(HttpClient $http_client): static
    {
        $this->http_client = $http_client;
        return $this;
    }

}
