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
        'datehappened',
        'timehappened',
        'longitude',
        'latitude',
        'details',
        'addnotes',
        'status'
    ];

    public function user(){
        return $this->belongsTo(User::class, 'residents_id', 'id');
    }
    
    public function forwardedreport(){
        return $this->hasMany(ForwardedReport::class);
    }
}
