<?php
/**
 * Create: Volodymyr
 */

namespace App\Helpers\Store;

use Illuminate\Support\Str;

/**
 * @method Vault vault()
 */
trait TraitGetSetValue
{

    /**
     * @throws ExceptionStoreVaultWrongKey
     */
    protected function batchGetValues(?array $keys): array
    {
        $values = [];
        $keys = $keys ?? $this->vault()->keys();
        foreach ($keys as $key) {
            $getter = Str::camel('get_' . $key);
            $values[$key] = $this->$getter();
        }
        return $values;
    }

    /**
     * @throws ExceptionStoreVaultWrongKey
     */
    protected function batchSetValues($values): static
    {
        foreach ($values as $key => $value) {
            $setter = Str::camel('set_' . $key);
            $this->$setter($value);
        }
        return $this;
    }

    /**
     * @throws ExceptionStoreVaultWrongKey
     */
    public function __call(string $name, array $arguments): mixed
    {
        $is = substr($name, 0, 3);
        $key = Str::snake(substr($name, 3));
        if ($is === 'get') {
            return $this->vault()->get($key);
        }
        if ($is === 'set') {
            $this->vault()->set($key, $arguments[0]);
            return $this;
        }
        return null;
    }

    /**
     * @throws ExceptionStoreVaultWrongKey
     */
    public function toArray(?array $keys = null): array
    {
        return $this->batchGetValues($keys ?? static::keys());
    }

}
