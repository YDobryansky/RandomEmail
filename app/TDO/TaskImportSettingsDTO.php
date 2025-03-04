<?php
/**
 * Create: Volodymyr
 */

namespace App\TDO;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Str;

class TaskImportSettingsDTO implements \JsonSerializable, \Stringable, \ArrayAccess, Arrayable
{
    protected string $file = '';
    protected array $file_fields = [];
    protected array $file_fields_settings = [];

    protected array $additional_fields = [];
    protected bool $overwrite = false;

    public function __construct()
    {
    }

    public function getFileFieldsSettings(): array
    {
        return $this->file_fields_settings;
    }

    public function setFileFieldsSettings(array $fieldsSettings): static
    {
        $value = [];

        foreach ($fieldsSettings as $field => $settings) {
            $value[$field] = $this->formatFieldSettings($settings ?? []);
        }

        $this->file_fields_settings = $value;

        return $this;
    }

    public function rebuildFileFieldSettings(array $fields): static
    {
        $value = [];
        $fieldsSettings = $this->getFileFieldsSettings();

        foreach ($fields as $field) {
            $value[$field] = $this->formatFieldSettings($fieldsSettings[$field] ?? []);
        }

        $this->file_fields_settings = $value;

        return $this;
    }

    private function formatFieldSettings(?array $settings = []): array
    {
        return [
            'allow' => $settings['allow'] ?? true,
        ];
    }

    public function getFile(): string
    {
        return $this->file;
    }

    public function setFile(string $file): static
    {
        $this->file = $file;
        return $this;
    }

    public function getFileFields(): array
    {
        return $this->file_fields;
    }

    public function setFileFields(array $file_fields): static
    {
        $this->file_fields = $file_fields;
        return $this;
    }

    public static function fromArray(array|TaskImportSettingsDTO $values): static
    {
        if ($values instanceof TaskImportSettingsDTO) {
            $values = $values->toArray();
        }
        return (new static())
            ->setFile($values['file'] ?? '')
            ->setFileFields($values['file_fields'] ?? [])
            ->setFileFieldsSettings($values['file_fields_settings'] ?? [])
            ->setOverwrite($values['overwrite'] ?? false)
            ->setAdditionalFields($values['additional_fields'] ?? [])
            ;
    }

    public static function fromJSON(?string $value): static
    {
        return static::fromArray(json_decode($value, true) ?? []);
    }

    public function __toString(): string
    {
        return json_encode($this->jsonSerialize());
    }

    public function toArray(): array
    {
        return [
            'file' => $this->getFile(),
            'file_fields' => $this->getFileFields(),
            'file_fields_settings' => $this->getFileFieldsSettings(),
            'overwrite' => $this->getOverwrite(),
            'additional_fields' => $this->getAdditionalFields(),
        ];
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }

    public function offsetExists(mixed $offset): bool
    {
        return property_exists($this, $offset);
    }

    public function offsetGet(mixed $offset): mixed
    {
        return $this->{Str::camel('get_' . $offset)}();
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        $this->{Str::camel('set_' . $offset)}($value);
    }

    public function offsetUnset(mixed $offset): void
    {
        $this->{Str::camel('set_' . $offset)}(null);
    }

    public function getAdditionalFields(): array
    {
        return $this->additional_fields;
    }

    public function setAdditionalFields(array $additional_fields): static
    {
        $this->additional_fields = $additional_fields;
        return $this;
    }

    public function addAdditionalField(string $field, $value = true): static
    {
        $this->additional_fields[$field] = $value;
        return $this;
    }

    public function getOverwrite(): bool
    {
        return $this->overwrite;
    }

    public function setOverwrite(bool $overwrite): static
    {
        $this->overwrite = $overwrite;
        return $this;
    }

}
