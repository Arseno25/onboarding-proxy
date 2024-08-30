<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Digiflazz extends Model
{
    use HasFactory;

    protected $table = 'digiurl';

    protected $fillable = [
        'url',
    ];
}
