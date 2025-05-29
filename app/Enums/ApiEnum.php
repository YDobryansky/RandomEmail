<?php
/**
 * Create: Volodymyr
 */

namespace App\Enums;

use App\API\Telegram\SendMessage\ServiceTelegramSendMessage;
use App\API\ZeroBounce\Activity\ServiceZeroBounceActivity;
use App\API\SendGrid\SendMail\ServiceSendGridSendMail;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum ApiEnum: string implements HasLabel, HasColor
{
    case ZERO_BOUNCE_ACTIVITY = ServiceZeroBounceActivity::class;
    case TELEGRAM_SEND_MESSAGE = ServiceTelegramSendMessage::class;
    case SENDGRID_SEND_MAIL = ServiceSendGridSendMail::class;

    static function toArray(): array
    {
        return [
            self::ZERO_BOUNCE_ACTIVITY->name => self::ZERO_BOUNCE_ACTIVITY->getLabel(),
            self::TELEGRAM_SEND_MESSAGE->name => self::TELEGRAM_SEND_MESSAGE->getLabel(),
            self::SENDGRID_SEND_MAIL->name => self::SENDGRID_SEND_MAIL->getLabel(),
        ];
    }

    public function getLabel(): ?string
    {
        return $this->value::getLabel();
    }

    public function getColor(): string|array|null
    {
        return $this->value::getColor();
    }

    public function getSettingsForm(string $block_key = 'settings')
    {
        return $this->value::getSettingsForm($block_key);
    }
}
