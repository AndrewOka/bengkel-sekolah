<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'users';
    
    // Tentukan primary key kustom sesuai database phpMyAdmin kamu
    protected $primaryKey = 'user_id'; 

    protected $fillable = [
        'username',
        'password',
        'full_name',
        'role_id',
        'is_active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Relasi ke Model Role
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id', 'role_id');
    }
}