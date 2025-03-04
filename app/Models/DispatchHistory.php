<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class DispatchHistory extends Model
{
    use HasFactory;

    protected $table = 'app_dispatch_histories';

    protected $guarded = ['id'];

    protected $casts = [];

    public $timestamps = false;

}
