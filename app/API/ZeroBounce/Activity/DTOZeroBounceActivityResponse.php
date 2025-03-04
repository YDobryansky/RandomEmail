<?php
/**
 * Create: Volodymyr
 */

namespace App\API\ZeroBounce\Activity;

use App\API\Common\Interfaces\ResponseInterface;
use App\API\Common\Traits\DTOHelps;

class DTOZeroBounceActivityResponse implements ResponseInterface
{
    use DTOHelps;

    protected bool $found = false;
    protected ?int $active_in_days = null;

    public function getFound(): bool
    {
        return $this->found;
    }

    public function setFound(bool $found): static
    {
        $this->found = $found;
        return $this;
    }

    public function getActiveInDays(): ?int
    {
        return $this->active_in_days;
    }

    public function setActiveInDays(null|int|string $active_in_days): static
    {
        $this->active_in_days = $active_in_days ? (int)$active_in_days : null;
        return $this;
    }

}
