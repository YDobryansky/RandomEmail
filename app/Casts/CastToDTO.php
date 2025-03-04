<?php
/**
 * Create: Volodymyr
 */

namespace App\Casts;

use App\TDO\TaskImportSettingsDTO;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

class CastToDTO implements CastsAttributes
{
    public function __construct(protected string $dtoClass)
    {
    }

    public function get(Model $model, string $key, mixed $value, array $attributes)
    {
        return $this->dtoClass::from($value, true);
    }

    public function set(Model $model, string $key, mixed $value, array $attributes)
    {
        return $this->dtoClass::from($value ?? [], true);
    }
}
