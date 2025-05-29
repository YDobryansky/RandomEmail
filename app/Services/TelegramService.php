<?php

namespace App\Services;

use App\API\Telegram\SendMessage\ServiceTelegramSendMessage;
use Illuminate\Support\Facades\Log;

class TelegramService
{
    public static function send(string $text): void
    {
        $settings = ServiceTelegramSendMessage::settings([
            'bot_id' => config('telegram.bot_id'),
            'chat_id' => config('telegram.chat_id'),
            'message_thread_id' => config('telegram.message_thread_id'),
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
