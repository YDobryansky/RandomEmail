<?php

namespace App\Models;

use App\TDO\ClientVaultDTO;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskTimetable extends Model
{
    use HasFactory;

    protected $table = 'app_task_timetables';

    public $timestamps = false;

    protected $guarded = ['id'];

    protected function data(): Attribute
    {
        return Attribute::make(
            get: function (mixed $value, array $attributes) {
                return ClientVaultDTO::fromArray(
                    json_decode($value, true)
                );
            },
            set: fn(mixed $value) => json_encode($value),
        );
    }

}
