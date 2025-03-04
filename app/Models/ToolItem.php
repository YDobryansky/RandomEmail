<?php

namespace App\Models;

use App\Enums\ToolItemStateEnum;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ToolItem extends Model
{
    use HasFactory;

    protected $table = 'app_tool_items';

    public $timestamps = false;

    protected $guarded = ['id'];
    protected $casts = [
        'state' => ToolItemStateEnum::class,
    ];

    const SOURCE = 'source';
    const RESULT = 'result';

    protected function values(): Attribute
    {
        return Attribute::make(
            get: fn(mixed $value, array $attributes) => json_decode($value, true),
            set: fn(mixed $value) => json_encode($value),
        );
    }
}
