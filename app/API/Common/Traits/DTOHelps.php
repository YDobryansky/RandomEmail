<?php
/**
 * Create: Volodymyr
 */

namespace App\API\Common\Traits;

trait DTOHelps
{
    protected static function keyToSnake(string $str): string
    {
        return str_replace('_', '', ucwords($str, '_'));
    }

    public static function fromArray(array $data, $ignore_null = true): static
    {
        return (new static())->fill($data, $ignore_null);
    }

    public function fill(array $data, $ignore_null = true): static
    {
        if ($ignore_null) {
            $data = array_filter($data, fn($value) => !is_null($value));
        }

        $methods = $this->keysToMethod(array_keys($data), 'set');

        foreach ($methods as $key => $method) {
            $this->$method($data[$key]);
        }
        return $this;
    }

    public function toArray(array $keys = [], $ignore_null = true): array
    {
        if (empty($keys)) {
            $keys = array_keys(get_object_vars($this));
        }

        $data = array_map(
            fn($method) => $this->$method(),
            $this->keysToMethod($keys, 'get')
        );

        if ($ignore_null) {
            $data = array_filter($data, fn($value) => !is_null($value));
        }
        return $data;
    }

    private function keysToMethod(array $keys, string $prefix = 'get'): array
    {
        $list = [];
        foreach ($keys as $key) {
            $method = $prefix . static::keyToSnake($key);
            $list[$key] = method_exists($this, $method) ? $method : null;
        }
        return array_filter($list);
    }

    public function keys(): array
    {
        return array_filter(
            array_keys(get_object_vars($this)),
            fn($key) => method_exists($this, 'get' . static::keyToSnake($key))
        );
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }

    public function __toString(): string
    {
        return json_encode($this->jsonSerialize());
    }
}
