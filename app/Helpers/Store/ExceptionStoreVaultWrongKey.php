<?php
/**
 * Create: Volodymyr
 */

namespace App\Helpers\Store;

class ExceptionStoreVaultWrongKey extends \Exception
{
    public static function create(string $key, ?array $allow_keys = []): static
    {
        $message = 'Store Vault wrong key: ' . $key;
        if (!empty($allow_keys)) {
            $message .= ' Allow keys: ' . implode(', ', $allow_keys);
        }

        return new static($message);
    }
}
