<?php
/**
 * Create: Volodymyr
 */

namespace App\API\Common\Exceptions;

class NotEnoughDataForRequestException extends APIException
{
    protected string $field_key = '';
    CONST MESSAGE = 'Field "%s" is required';

    public static function make(string $field_key): static
    {
        return new static(sprintf(static::MESSAGE, $field_key));
    }

    public function __construct(...$args)
    {
        parent::__construct(...$args);
    }

    public function getFieldKey(): string
    {
        return $this->field_key;
    }

    public function setFieldKey(string $field_key): static
    {
        $this->field_key = $field_key;
        return $this;
    }

}
