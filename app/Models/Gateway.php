<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gateway extends Model
{
    use HasFactory;

    protected $table = 'app_gateways';

    protected $guarded = ['id'];

    protected $casts = [
        'settings' => 'array',
    ];

}
