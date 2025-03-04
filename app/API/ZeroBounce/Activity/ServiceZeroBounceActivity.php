<?php
/**
 * Create: Volodymyr
 */

namespace App\API\ZeroBounce\Activity;

use App\API\Common\Exceptions\APIException;
use App\API\Common\Interfaces\RequestInterface;
use App\API\Common\Interfaces\ServiceInterface;
use App\API\Common\Interfaces\SettingsInterface;
use Filament\Support\Colors\Color;

class ServiceZeroBounceActivity implements ServiceInterface
{
    /**
     * @throws APIException
     */
    public static function send(DTOZeroBounceActivitySettings|SettingsInterface $settings, DTOZeroBounceActivityRequest|RequestInterface $request): DTOZeroBounceActivityResponse
    {
        return ApiZeroBounceActivity::send($settings, $request);
    }

    public static function settings(array $data): DTOZeroBounceActivitySettings
    {
        return DTOZeroBounceActivitySettings::fromArray($data);
    }

    public static function request(array $data): DTOZeroBounceActivityRequest
    {
        return DTOZeroBounceActivityRequest::fromArray($data);
    }

    public static function response(array $data, bool $ignore_null = true): DTOZeroBounceActivityResponse
    {
        return DTOZeroBounceActivityResponse::fromArray($data, $ignore_null);
    }

    public static function getColor(): array
    {
        return Color::Green;
    }

    public static function getLabel(): string
    {
        return 'Zero Bounce / Activity';
    }

    public static function getKey(): string
    {
        return 'zero_bounce_activity';
    }

    public static function getSettingsForm(string $block_key = 'settings'): array
    {
        return DTOZeroBounceActivitySettings::form($block_key);
    }

}
