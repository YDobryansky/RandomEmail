<?php

namespace App\Services;

use App\API\Telegram\SendMessage\ServiceTelegramSendMessage;
use App\Models\Api;
use Illuminate\Support\Facades\Log;

class TelegramService
{
    public static function send(string $text): void
    {
        $settings = ServiceTelegramSendMessage::settings([
            'bot_id' => Api::getSettingValue(Api::TELEGRAM_BOT, 'bot_id'),
            'chat_id' => Api::getSettingValue(Api::TELEGRAM_CHAT, 'chat_id'),
            'message_thread_id' => Api::getSettingValue(Api::TELEGRAM_CHAT, 'thread_id'),
        ]);

        $request = ServiceTelegramSendMessage::request([
            'text' => $text,
        ]);

        try {
            ServiceTelegramSendMessage::send($settings, $request);
        } catch (\Throwable $e) {
            Log::error('Telegram send failed: ' . $e->getMessage(), ['exception' => $e]);
        }
    }
}