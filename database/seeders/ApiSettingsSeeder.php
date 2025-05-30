<?php

namespace Database\Seeders;

use App\Models\Api;
use Illuminate\Database\Seeder;

class ApiSettingsSeeder extends Seeder
{
    public function run(): void
    {
        $apis = [
            [
                'name' => Api::TELEGRAM_BOT,
                'settings' => [
                    'bot_id' => env('TELEGRAM_BOT_ID'),
                ],
            ],
            [
                'name' => Api::TELEGRAM_CHAT,
                'settings' => [
                    'chat_id' => env('TELEGRAM_CHAT_ID'),
                    'thread_id' => env('TELEGRAM_THREAD_ID'),
                ],
            ],
            [
                'name' => Api::SENDGRID,
                'settings' => [
                    'api_key' => env('SENDGRID_API_KEY'),
                ],
            ],
        ];

        foreach ($apis as $api) {
            Api::updateOrCreate(
                ['name' => $api['name']],
                ['settings' => $api['settings']]
            );
        }
    }
}