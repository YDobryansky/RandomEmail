<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ToolItemHistory extends Model
{
    use HasFactory;

    protected $table = 'app_tool_item_histories';

    protected $guarded = ['id'];

    protected $casts = [
        'value' => 'array',
    ];

    public $timestamps = false;

}
