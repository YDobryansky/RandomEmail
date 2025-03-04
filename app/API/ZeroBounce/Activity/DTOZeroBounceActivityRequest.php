<?php
/**
 * Create: Volodymyr
 */

namespace App\API\ZeroBounce\Activity;

use App\API\Common\Interfaces\RequestInterface;
use App\API\Common\Traits\DTOHelps;

class DTOZeroBounceActivityRequest implements RequestInterface
{
    use DTOHelps;

    protected ?string $email = null;
    protected ?string $api_key = null;

    public function emptyRequiredArgs(): array
    {
        return array_filter([
            'email' => empty($this->getEmail()),
            'api_key' => empty($this->getApiKey()),
        ]);
    }

    public function isEmptyRequiredArgs(): bool
    {
        return !empty($this->emptyRequiredArgs());
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): static
    {
        $this->email = $email;
        return $this;
    }

    public function getApiKey(): ?string
    {
        return $this->api_key;
    }

    public function setApiKey(?string $api_key): static
    {
        $this->api_key = $api_key;
        return $this;
    }

}
