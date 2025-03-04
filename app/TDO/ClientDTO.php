<?php

namespace App\TDO;

use Illuminate\Contracts\Support\Jsonable;

class ClientDTO implements \JsonSerializable
{
    protected ?string $phone = null;
    protected ?string $email = null;
    protected ?string $country = null;
    protected ?string $first_name = null;

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): static
    {
        $this->phone = $phone;
        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;
        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(?string $country): static
    {
        $this->country = $country;
        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->first_name;
    }

    public function setFirstName(?string $first_name): static
    {
        $this->first_name = $first_name;
        return $this;
    }

    public static function fromArray($array): static
    {
        return (new static())
            ->setCountry($array['country'] ?? null)
            ->setPhone($array['phone'] ?? null)
            ->setFirstName($array['first_name'] ?? null)
            ->setEmail($array['email'] ?? null);
    }

    public function jsonSerialize(): mixed
    {
        return [
            'first_name' => $this->getFirstName(),
            'phone' => $this->getPhone(),
            'country' => $this->getCountry(),
            'email' => $this->getEmail(),
        ];
    }
}
