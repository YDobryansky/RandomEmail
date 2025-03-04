<?php
/**
 * Create: Vladimir
 */

namespace NotificationChannels\AbstractDriver;

use Illuminate\Http\Client\Response;

abstract class AbstractDriverSmsRespond extends AbstractDriverRespond
{
    protected string $external_id = '';
    protected string $to = '';
    protected string $external_id_key;

	public function __construct(Response $response, string $to)
	{
		parent::__construct($response);
		$this->setTo($to);
	}

	protected function parseResponse(): void
    {
        $body = $this->getResponse()->json();
        $this->setExternalId((string)$body[$this->external_id_key]);
    }

    public function setExternalId(string $external_id): static
    {
        $this->external_id = $external_id;
        return $this;
    }

    public function getExternalId(): string
    {
        return $this->external_id;
    }

    public function __toString(): string
    {
        return $this->getExternalId();
    }

    /**
     * @return string
     */
    public function getTo(): string
    {
        return $this->to;
    }

    /**
     * @param string $to
     * @return static
     */
    public function setTo(string $to): static
    {
        $this->to = $to;
        return $this;
    }

    public function jsonSerialize(): array
    {
        return [
            'external_id' => $this->getExternalId(),
            'to' => $this->getTo(),
        ];
    }

}
