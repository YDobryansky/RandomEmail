<?php
/**
 * Create: Volodymyr
 */

namespace App\API\Telegram\SendMessage;

use App\API\Common\Exceptions\APIException;
use App\API\Common\Interfaces\RequestInterface;
use App\API\Common\Interfaces\ServiceInterface;
use App\API\Common\Interfaces\SettingsInterface;
use Filament\Support\Colors\Color;

class ServiceTelegramSendMessage implements ServiceInterface
{
    /**
     * @throws APIException
     */
    public static function send(
        DTOTelegramSendMessageSettings|SettingsInterface $settings,
        DTOTelegramSendMessageRequest|RequestInterface   $request
    ): DTOTelegramSendMessageResponse
    {
        return ApiTelegramSendMessage::send($settings, $request);
    }

    public static function settings(array $data): DTOTelegramSendMessageSettings
    {
        return DTOTelegramSendMessageSettings::fromArray($data);
    }

    public static function request(array $data): DTOTelegramSendMessageRequest
    {
        return DTOTelegramSendMessageRequest::fromArray($data);
    }

    public static function response(array $data, bool $ignore_null = true): DTOTelegramSendMessageResponse
    {
        return DTOTelegramSendMessageResponse::fromArray($data, $ignore_null);
    }

    public static function getColor(): array
    {
        return Color::Blue;
    }

    public static function getLabel(): string
    {
        return 'Telegram / Send Message';
    }

    public static function getKey(): string
    {
        return 'telegram_send_message';
    }

    public static function getSettingsForm(string $block_key = 'settings'): array
    {
        return DTOTelegramSendMessageSettings::form($block_key);
    }

}
