<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class Admin extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    protected $guard = "admin";

    protected $fillable = [
        'name',
        'email',
        'password',
        'ofic_id',
        'pers_id',
        'ofic_name',
        'rol_name',
        'active',
    ];

    protected $hidden = [
        'password',
        //'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'active' => 'boolean',
        'password' => 'hashed',
    ];

    public function oficina()
    {
        return $this->belongsTo(Oficina::class, 'ofic_id');
    }

    public function persona()
    {
        return $this->belongsTo(Persona::class, 'pers_id');
    }
}
