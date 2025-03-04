<?php
/**
 * Create: Volodymyr
 */

namespace App\API\Common\Interfaces;

interface RequestInterface
{
    public function emptyRequiredArgs(): array;

    public function isEmptyRequiredArgs(): bool;

}
