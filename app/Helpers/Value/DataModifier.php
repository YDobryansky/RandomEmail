<?php
/**
 * Create: Volodymyr
 */

namespace App\Helpers\Value;

class DataModifier
{
    public function __construct(protected array $map)
    {
    }

    public function replace(array $data): array
    {
        $replace = [];
        foreach ($data as $key => $value) {
            $replace['{' . $key . '}'] = $value;
        }

        foreach ($this->map as $map) {
            $data[$map['name']] = str_replace(array_keys($replace), array_values($replace), $map['value']);
        }
        return $data;
    }

}
