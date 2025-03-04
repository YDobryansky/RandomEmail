<?php
/**
 * Create: Volodymyr
 */

namespace App\API\ZeroBounce\Activity;

use App\API\Common\Interfaces\SettingsInterface;
use App\API\Common\Traits\DTOHelps;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;

class DTOZeroBounceActivitySettings implements SettingsInterface
{
    use DTOHelps;

    protected string $path = '/v2/activity';
    protected string $domain = self::DOMAIN_DEFAULT;
    protected string $api_key;
    const DOMAIN_DEFAULT = 'https://api.zerobounce.net';
    const DOMAIN_USA = 'https://api-us.zerobounce.net';

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
        return $this->getDomain() . $this->getPath();
    }

    public function getDomain(): string
    {
        return $this->domain;
    }

    public function setDomain(string $domain): static
    {
        $this->domain = $domain;
        return $this;
    }

    public function getApiKey(): string
    {
        return $this->api_key;
    }

    public function setApiKey(string $api_key): static
    {
        $this->api_key = $api_key;
        return $this;
    }

    public static function form(string $block_key = 'settings'): array
    {
        return [
            TextInput::make($block_key . '.api_key')
                ->required(),
            Select::make($block_key . '.domain')
                ->required()
                ->options([
                    static::DOMAIN_DEFAULT => static::DOMAIN_DEFAULT,
                    static::DOMAIN_USA => static::DOMAIN_USA
                ]),
            TestFilamentZeroBounceActivity::make($block_key)
        ];
    }

}
