<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ForwardedReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'reports_id',
        'status',
        'barangay',
    ];

    public function report(){
        return $this->belongsTo(Report::class);
    }
}
