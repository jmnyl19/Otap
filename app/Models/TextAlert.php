<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TextAlert extends Model
{
    use HasFactory;

    protected $fillable = [
        'responder',
        'number',
    ];
}
