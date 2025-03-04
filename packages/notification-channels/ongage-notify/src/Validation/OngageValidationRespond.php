<?php
/**
 * Create: Vladimir
 */

namespace NotificationChannels\OngageNotify\Validation;

use NotificationChannels\AbstractDriver\AbstractDriverRespond;
use NotificationChannels\OngageNotify\Enums\EnumOngageValidationStatus;

class OngageValidationRespond extends AbstractDriverRespond
{
    protected int $status = EnumOngageValidationStatus::UNKNOWN;
    protected string $reason = '';

    protected function parseResponse(): static
    {
        $body = $this->getResponse()->json();

        $this->setStatus($body['status']);
        $this->setReason($body['reason']);

        return $this;
    }

    public function getStatus(): int
    {
        return $this->status;
    }

    public function setStatus(int|string $status): static
    {
        if (is_string($status)) {
            $status = EnumOngageValidationStatus::getByKey(strtoupper($status))['id'] ?? EnumOngageValidationStatus::UNKNOWN;
        }

        $this->status = $status;
        return $this;
    }

    public function getReason(): string
    {
        return $this->reason;
    }

    public function setReason(string $reason): static
    {
        $this->reason = $reason;
        return $this;
    }

}
