<?php
/**
 * Create: Volodymyr
 */

namespace App\API\Common\Interfaces;

use App\API\Common\Exceptions\APIException;
use App\API\Telegram\SendMessage\DTOTelegramSendMessageResponse;

interface ServiceInterface
{
    /**
     * @throws APIException
     */
    public static function send(SettingsInterface $settings, RequestInterface $request): ResponseInterface;

    public static function settings(array $data): SettingsInterface;

    public static function request(array $data): RequestInterface;

    public static function response(array $data, bool $ignore_null = true): ResponseInterface;

    public static function getColor(): array;

    public static function getLabel(): string;

    public static function getKey(): string;

    public static function getSettingsForm(string $block_key = 'settings'): array;
}
