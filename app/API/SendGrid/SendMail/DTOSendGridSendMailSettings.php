<?php
namespace App\API\SendGrid\SendMail;

use App\API\Common\Interfaces\SettingsInterface;
use App\API\Common\Traits\DTOHelps;
use Filament\Forms\Components\TextInput;

class DTOSendGridSendMailSettings implements SettingsInterface
{
    use DTOHelps;

    protected string $domain = 'https://api.sendgrid.com';
    protected string $path = '/v3/mail/send';
    protected ?string $api_key = null;

    public function getDomain(): string
    {
        return $this->domain;
    }

    public function setDomain(string $domain): static
    {
        $this->domain = $domain;
        return $this;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function setPath(string $path): static
    {
        $this->path = $path;
        return $this;
    }

    public function url(): string
    {
        return rtrim($this->domain, '/') . $this->path;
    }

    public function getApiKey(): ?string
    {
        return $this->api_key;
    }

    public function setApiKey(?string $api_key): static
    {
        $this->api_key = $api_key;
        return $this;
    }

    public static function form(string $block_key = 'settings'): array
    {
        return [
            TextInput::make($block_key . '.api_key')->required(),
        ];
    }
}
