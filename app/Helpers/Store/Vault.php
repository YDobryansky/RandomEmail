<?php
/**
 * Create: Volodymyr
 */

namespace App\Helpers\Store;

class Vault
{
    protected array $data = [];

    protected ?array $keys = null;
    protected array $default = [];
    protected bool $on_wrong_key_use_exception = true; // exception

    public function __construct(?array $keys = null, array $default = [], $on_wrong_key_use_exception = true)
    {
        $this->keys = $keys;
        $this->on_wrong_key_use_exception = $on_wrong_key_use_exception;
        $this->default = $default;
    }

    /**
     * @throws ExceptionStoreVaultWrongKey
     */
    public function set($key, $value): static
    {
        if (!$this->checkKey($key)) {
            return $this;
        }
        $this->data[$key] = $value;
        return $this;
    }

    /**
     * @throws ExceptionStoreVaultWrongKey
     */
    public function get($key): mixed
    {
        if (!$this->checkKey($key)) {
            return null;
        }
        return $this->data[$key] ?? ($this->default[$key] ?? null);
    }

    /**
     * @throws ExceptionStoreVaultWrongKey
     */
    public function checkKey($key): bool
    {
        if ($this->keys && !in_array($key, $this->keys)) {
            if ($this->on_wrong_key_use_exception) {
                throw ExceptionStoreVaultWrongKey::create($key);
            }
            return false;
        }
        return true;
    }

    public function getData(): array
    {
        return $this->data;
    }

    public function keys(): array
    {
        return array_keys($this->data);
    }


}
