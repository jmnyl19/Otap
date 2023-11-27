<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ForwardedIncident extends Model
{
    use HasFactory;

    protected $fillable = [
        'incidents_id',
        'status',
        'barangay',
    ];

    public function incident(){
        return $this->belongsTo(Incident::class);
    }


}
