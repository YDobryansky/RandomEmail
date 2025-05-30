<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Api extends Model
{
    use HasFactory;

    protected $table = 'app_apis';

    public $timestamps = false;

    protected $guarded = ['id'];

    const TELEGRAM_BOT = 'telegram_bot';
    const TELEGRAM_CHAT = 'telegram_chat';
    const SENDGRID = 'sendgrid';

    protected function settings(): Attribute
    {
        return Attribute::make(
            get: fn(mixed $value, array $attributes) => json_decode($value, true),
            set: fn(mixed $value) => json_encode($value),
        );
    }

    public static function getSettingValue(string $key, string $setting = null): ?string 
    {
        $api = self::where('name', $key)->first();
        return $api?->settings[$setting] ?? null;
    }
}