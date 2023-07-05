<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\Request;
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
        'updated_at',
        'created_at',
        //'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'active' => 'boolean',
        'password' => 'hashed',
    ];

    public static $headers =  [
        ['text' => "Nombre", 'value' => "name", 'short' => false, 'order' => 'ASC'],
        ['text' => "email", 'value' => "email", 'short' => false, 'order' => 'ASC'],
        ['text' => "Oficina", 'value' => "ofic_name", 'short' => false, 'order' => 'ASC'],
        ['text' => "Rol", 'value' => "rol_name", 'short' => false, 'order' => 'ASC'],
        ['text' => "Estado", 'value' => "active", 'short' => false, 'order' => 'ASC'],

    ];

    public function oficina()
    {
        return $this->belongsTo(Oficina::class, 'ofic_id');
    }

    public function persona()
    {
        return $this->belongsTo(Persona::class, 'pers_id');
    }

    public static function getAdmins(Request $request)
    {
        $perPage = $request->input('perPage', 10);
        $query = self::query();

        if ($request->has('search')) {
            $searchTerm = $request->search;
            $query->where('name', 'like', '%' . $searchTerm . '%')
                ->orWhere('email', 'like', '%' . $searchTerm . '%')
                ->orWhere('ofic_name', 'like', '%' . $searchTerm . '%')
                ->orWhere('rol_name', 'like', '%' . $searchTerm . '%');
        }

        $items = $query->paginate($perPage)->appends($request->query());

        return [
            'items' => $items,
            'headers' => self::$headers,
            'filters' => [
                'search' => $request->search,
            ],
        ];
        // return self::all();
    }
}
