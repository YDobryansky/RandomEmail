<?php
/**
 * Create: Volodymyr
 */

namespace App\API\Common\Interfaces;

interface ResponseInterface
{
    public static function fromArray(array $data): static;

}
