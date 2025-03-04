<?php
/**
 * Create: Volodymyr
 */

namespace NotificationChannels\OngageNotify\Contact;

class OngageContactMessageDTO implements \JsonSerializable, \Stringable
{
    protected string $email;
    protected ?bool $overwrite = null;
    protected array $fields = [];

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;
        return $this;
    }

    public function getOverwrite(): ?bool
    {
        return $this->overwrite;
    }

    public function setOverwrite(?bool $overwrite): static
    {
        $this->overwrite = $overwrite;
        return $this;
    }

    public function getFields(): array
    {
        return $this->fields;
    }

    public function setFields(array $fields): static
    {
        foreach ($fields as $key => $value) {
            $this->addField($key, $value);
        }
        return $this;
    }

    public function addField(string $key, null|string|int|float|bool $value): static
    {
        if ($value === null) {
            return $this;
        }
        if ($key === 'email') {
            $this->setEmail($value);
            return $this;
        }
        $this->fields[$key] = $value;
        return $this;
    }

    public function jsonSerialize(): array
    {
        return array_filter([
            'email' => $this->getEmail(),
            'overwrite' => $this->getOverwrite(),
            'fields' => $this->getFields(),
        ]);
    }

    public function __toString(): string
    {
        return json_encode($this->jsonSerialize());
    }
}
