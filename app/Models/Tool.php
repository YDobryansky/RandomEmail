<?php

namespace App\Models;

use App\Enums\ToolStatusEnum;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Storage;

class Tool extends Model
{
    use HasFactory;

    protected $table = 'app_tools';

    public $timestamps = false;

    protected $guarded = ['id'];

    const SETTING_MODIFIER = 'modifier';

    protected $casts = [
        'status' => ToolStatusEnum::class,
    ];

    public function api(): HasOne
    {
        return $this->hasOne(Api::class, 'id', 'api_id');
    }

    public function items(): HasMany
    {
        return $this->hasMany(ToolItem::class, 'tool_id', 'id');
    }

    protected function settings(): Attribute
    {
        $self = $this;
        return Attribute::make(
            get: fn(mixed $value, array $attributes) => json_decode($value, true),
            set: function (mixed $value) use ($self) {
                if (is_array($value) and !count($value)) {
                    return json_encode($value);
                }
                return json_encode([
                    ...($self->getOriginal('settings') ?? []),
                    ...($value ?? [])
                ]);
            },
        );
    }

}
