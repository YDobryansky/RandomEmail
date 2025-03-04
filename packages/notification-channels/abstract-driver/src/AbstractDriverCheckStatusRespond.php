<?php
/**
 * Create: Vladimir
 */

namespace NotificationChannels\AbstractDriver;

abstract class AbstractDriverCheckStatusRespond extends AbstractDriverRespond
{
    protected string $external_id = '';
    protected string $to = '';
    protected string $raw_status;
    protected string $status;

    public function setExternalId(string $external_id): static
    {
        $this->external_id = $external_id;
        return $this;
    }

    public function getExternalId(): string
    {
        return $this->external_id;
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

    /**
     * @return string
     */
    public function getRawStatus(): string
    {
        return $this->raw_status;
    }

    /**
     * @param string $raw_status
     * @return static
     */
    public function setRawStatus(string $raw_status): static
    {
        $this->raw_status = $raw_status;
        return $this;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @param string $status
     * @return static
     */
    public function setStatus(string $status): static
    {
        $this->status = $status;
        return $this;
    }

    public function __toString(): string
    {
        return $this->getStatus();
    }

    public function jsonSerialize(): array
    {
        return [
            'external_id' => $this->getExternalId(),
            'to' => $this->getTo(),
            'status' => $this->getStatus(),
            'status_raw' => $this->getRawStatus(),
        ];
    }

}
