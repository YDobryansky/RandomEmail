<?php
/**
 * Create: Volodymyr
 */

namespace App\Helpers\Store;

use Illuminate\Contracts\Support\Arrayable;

abstract class AbstractDTO implements \JsonSerializable, \Stringable, Arrayable
{
    use TraitGetSetValue;

    protected Vault $vault;

    public function __construct()
    {
        $this->vault = new Vault(
            keys: static::keys(),
            default: static::default()
        );
    }

    public function vault(): Vault
    {
        return $this->vault;
    }

    public static abstract function keys(): ?array;

    public static function default(): array
    {
        return [];
    }

    public static function from(array|string|null|self $value, $allow_only = true): static
    {
        if (is_string($value)) {
            $value = json_decode($value, true);
        }

        if ($value instanceof self) {
            return $value;
        } elseif (is_array($value)) {
            return static::fromArray($value, $allow_only);
        }
        return new static();
    }

    public static function fromString(string $value, $allow_only = true): static
    {
        return static::fromArray((array)json_decode($value, true), $allow_only);
    }

    /**
     * @throws ExceptionStoreVaultWrongKey
     */
    public static function fromArray($values, $allow_only = true): static
    {
        if ($allow_only && static::keys()) {
            $values = array_intersect_key($values, array_flip(static::keys()));
        }
        return (new static())->batchSetValues($values);
    }

    /**
     * @throws ExceptionStoreVaultWrongKey
     */
    public function jsonSerialize(): array
    {
        return $this->batchGetValues(static::keys());
    }

    public function __toString(): string
    {
        return json_encode($this->jsonSerialize());
    }
}
