<?php
namespace App\API\SendGrid\SendMail;

use App\API\Common\Exceptions\APIException;
use App\API\Common\Interfaces\RequestInterface;
use App\API\Common\Interfaces\ServiceInterface;
use App\API\Common\Interfaces\SettingsInterface;
use Filament\Support\Colors\Color;

class ServiceSendGridSendMail implements ServiceInterface
{
    /**
     * @throws APIException
     */
    public static function send(
        DTOSendGridSendMailSettings|SettingsInterface $settings,
        DTOSendGridSendMailRequest|RequestInterface   $request
    ): DTOSendGridSendMailResponse {
        return ApiSendGridSendMail::send($settings, $request);
    }

    public static function settings(array $data): DTOSendGridSendMailSettings
    {
        return DTOSendGridSendMailSettings::fromArray($data);
    }

    public static function request(array $data): DTOSendGridSendMailRequest
    {
        return DTOSendGridSendMailRequest::fromArray($data);
    }

    public static function response(array $data, bool $ignore_null = true): DTOSendGridSendMailResponse
    {
        return DTOSendGridSendMailResponse::fromArray($data, $ignore_null);
    }

    public static function getColor(): array
    {
        return Color::Rose;
    }

    public static function getLabel(): string
    {
        return 'SendGrid / Send Mail';
    }

    public static function getKey(): string
    {
        return 'sendgrid_send_mail';
    }

    public static function getSettingsForm(string $block_key = 'settings'): array
    {
        return DTOSendGridSendMailSettings::form($block_key);
    }
}
