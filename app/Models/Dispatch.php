<?php

namespace App\Models;

use App\Casts\CastToDTO;
use App\TDO\ClientVaultDTO;
use App\TDO\JobSettingsDTO;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Dispatch extends Model
{
    use HasFactory;

    protected $table = 'app_dispatches';

    protected $guarded = ['id'];

    protected $casts = [
        'settings' => CastToDTO::class . ':' . JobSettingsDTO::class,
    ];

    public function gateway(): BelongsTo
    {
        return $this->belongsTo(Gateway::class);
    }

    public function task(): BelongsTo
    {
        return $this->belongsTo(Task::class);
    }

    protected function data(): Attribute
    {
        return Attribute::make(
            get: function (mixed $value, array $attributes) {
                if ($value and str_starts_with($value, '{')) {
                    return ClientVaultDTO::fromArray(json_decode($value, true));
                }
                return unserialize($value);
            },
            set: function (mixed $value) {
//                if ($value instanceof ClientVaultDTO) {
//                    $value = $value->toArray();
//                }
                return json_encode($value);
            },
        );
    }

    protected function history(): HasMany
    {
        return $this->hasMany(DispatchHistory::class, 'dispatch_id');
    }

}
