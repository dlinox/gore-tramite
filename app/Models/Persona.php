<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    use HasFactory;

    protected $primaryKey = 'pers_id';

    protected $fillable = [
        'pers_nombre',
        'pers_paterno',
        'pers_materno',
        'pers_fecha_nacimiento',
        'pers_dni',
        'pers_ruc',
        'pers_tipo_documento',
        'pers_ugigeo',
        'pers_direccion',
        'pers_celular',
        'pers_correo',
        'pers_pais',
        'pers_estado',
    ];

    protected $casts = [
        'pers_fecha_nacimiento' => 'date',
        'pers_estado' => 'boolean',
    ];
}
