<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestLog extends Model
{
    use HasFactory;

    protected $fillable = ['provider','endpoint', 'data', 'meta'];
    protected $casts = [
        'data' => 'array',
        'meta' => 'array',
    ];
}
