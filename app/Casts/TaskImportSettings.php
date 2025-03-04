<?php

namespace App\Casts;

use App\Helpers\File\FileCSV;
use App\TDO\TaskImportSettingsDTO;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class TaskImportSettings implements CastsAttributes
{
    private string $field_key;
    public function __construct(string $field_key = 'file')
    {
        $this->field_key = $field_key;
    }

    /**
     * Cast the given value.
     *
     * @param array<string, mixed> $attributes
     */
    public function get(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        return TaskImportSettingsDTO::fromJSON($value ?? '');
    }

    /**
     * Prepare the given value for storage.
     *
     * @param array<string, mixed> $attributes
     */
    public function set(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        $file = $attributes[$this->field_key] ?? '';

        if ($file) {
            $value = TaskImportSettingsDTO::fromArray($value ?? []);

            if ($file !== $value->getFile()) {
                $fields = (new FileCSV(Storage::path($file)))->getHeader();
                $value
                    ->setFile($file)
                    ->setFileFields($fields)
                    ->rebuildFileFieldSettings($fields);
            }
        } else {
            $value = new TaskImportSettingsDTO();
        }

        return $value;
    }
}
