<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ForwardedIncident extends Model
{
    use HasFactory;

    public function incidents(){
        return $this->belongsTo(Incident::class);
    }
    public function user(){
        return $this->belongsTo(User::class, 'residents_id', 'id');
    }
}
