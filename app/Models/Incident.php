<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Incident extends Model
{
    use HasFactory;

    protected $fillable = [
        'residents_id',
        'type',
        'status',
    ];

    public function user(){
        return $this->belongsTo(User::class, 'residents_id', 'id');
    }
    public function forwardedincidents(){
        return $this->belongsTo(ForwardedIncident::class);
    }
}
