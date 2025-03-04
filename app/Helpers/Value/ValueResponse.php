<?php
/**
 * Create: Vladimir
 */

namespace App\Helpers\Value;

use Illuminate\Http\Client\Response;
use Psr\Http\Message\UriInterface;

class ValueResponse
{
    public function __construct(protected Response $response)
    {
    }

    protected array $headers_protected = [
        'Authorization',
    ];

    protected array $query_protected = [
        'token',
        'password',
    ];

    protected int $max_body_length = 0;
    protected bool $is_body_json = true;

    public function jsonSerialize(): array
    {
        return $this->information();
    }

    public function getResponseStatus(): int
    {
        return $this->response->status();
    }

    public function getResponseReason(): string
    {
        return $this->response->reason();
    }

    public function getResponseBody(): mixed
    {
        $body = $this->response->body();
        if ($this->max_body_length > 0 && mb_strlen($body) > $this->max_body_length) {
            $body = mb_substr($body, 0, $this->max_body_length) . ' [cut]';
        } else {
            if ($this->is_body_json) {
                try {
                    $body = json_decode($body, true, flags: JSON_THROW_ON_ERROR);
                } catch (\Exception) {

                }
            }
        }

        return $body;
    }

    public function getRequestUrl(): string
    {
        /**
         * @var UriInterface $uri
         */
        $uri = $this->response->transferStats->getRequest()->getUri();

        parse_str($uri->getQuery(), $query);
        foreach ($this->query_protected as $key) {
            if (isset($query[$key])) {
                $query[$key] = '-----';
            }
        }

        return $uri->withQuery(http_build_query($query));
    }

    public function getRequestBody(): mixed
    {
        $body = (string)$this->response->transferStats->getRequest()->getBody();
        return json_decode($body, true) ?? $body;
    }

    public function getRequestHeaders(): array
    {
        $headers = $this->response->transferStats->getRequest()->getHeaders();
        foreach ($headers as $key => $value) {
            $headers[$key] = in_array($key, $this->headers_protected) ? '*****' : implode(',', $value);
        }

        return $headers;
    }

    public function getResponse(): Response
    {
        return $this->response;
    }

    public function setHeadersProtected(array $headers_protected): static
    {
        $this->headers_protected = $headers_protected;
        return $this;
    }

    public function addHeaderProtected(array $header): static
    {
        $this->headers_protected[] = $header;
        return $this;
    }

    public function setQueryProtected(array $query_protected): static
    {
        $this->query_protected = $query_protected;
        return $this;
    }

    public function addQueryProtected(array $agr): static
    {
        $this->query_protected[] = $agr;
        return $this;
    }

    public function setMaxBodyLength(int $max_body_length): static
    {
        $this->max_body_length = $max_body_length;
        return $this;
    }

    public function setIsBodyJson(bool $is_body_json): static
    {
        $this->is_body_json = $is_body_json;
        return $this;
    }

    public function information(): array
    {
        return [
            'response' => [
                'code' => $this->getResponseStatus(),
                'message' => $this->getResponseReason(),
                'respond' => $this->getResponseBody(),
            ],
            'request' => [
                'url' => $this->getRequestUrl(),
                'headers' => $this->getRequestHeaders(),
                'body' => $this->getRequestBody(),
            ],
        ];
    }
}
