<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable 
// implements Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable; 

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'age',
        'birthday',
        'contact_no',
        'lot_no',
        'street',
        'barangay',
        'city',
        'province',
        'email',
        'password',
        'profile_picture',
        'admin_name',
        'role'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function reports(){
        return $this->hasMany(Report::class, 'residents_id', 'id');   
    }

    public function incidents(){
        return $this->hasMany(Incident::class, 'residents_id', 'id');
    }
}

// class User extends Model
// {
//     use HasFactory;

//     public function complaints(){
//         return $this->hasMany(Complaint::class);
//     }
// }
