<?php
/**
 * Create: Volodymyr
 */

namespace NotificationChannels\OngageNotify\DTO;

class OngageApiSettingsDTO
{
    protected ?string $base_url = null;

    protected ?string $password = null;
    protected ?string $login = null;
    protected ?string $account_code = null;
    protected ?string $list_id = null;

    public function getBaseUrl(): string
    {
        return str_replace(
            '{list_id}',
            $this->getListId(),
            $this->base_url ?? config('ongage-notify.base_url')
        );
    }

    public function setBaseUrl(string $base_url): static
    {
        $this->base_url = $base_url;
        return $this;
    }

    public function getPassword(): string
    {
        return $this->password ?? config('ongage-notify.password');
    }

    public function setPassword(?string $password = null): static
    {
        if ($password !== null) {
            $this->password = $password;
        }
        return $this;
    }

    public function getLogin(): string
    {
        return $this->login ?? config('ongage-notify.login');
    }

    public function setLogin(?string $login = null): static
    {
        if ($login !== null) {
            $this->login = $login;
        }
        return $this;
    }

    public function getAccountCode(): string
    {
        return $this->account_code ?? config('ongage-notify.account_code');
    }

    public function setAccountCode(string $account_code): static
    {
        $this->account_code = $account_code;
        return $this;
    }

    public function getListId(): string
    {
        return $this->list_id ?? config('ongage-notify.list_id');
    }

    public function setListId(string $list_id): static
    {
        $this->list_id = $list_id;
        return $this;
    }

}
