<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $fillable = [
        'residents_id',
        'file',
        'details',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
