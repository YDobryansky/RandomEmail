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

    protected function settings(): Attribute
    {
        return Attribute::make(
            get: fn(mixed $value, array $attributes) => json_decode($value, true),
//            get: function (mixed $value, array $attributes) {
//                return ClientVaultDTO::fromArray(
//                    json_decode($value, true)
//                );
//            },
            set: fn(mixed $value) => json_encode($value),
        );
    }
}
