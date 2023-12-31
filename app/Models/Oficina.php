<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Oficina extends Model
{
    use HasFactory;

    protected $primaryKey = 'ofic_id';

    protected $fillable = [
        'ofic_nombre',
        'ofic_descripcion',
        'ofic_ubigeo',
        'ofic_direccion',
        'ofic_estado',
        'ofic_siglas',
        'ofic_publico'
    ];

    protected $hidden = [
        'updated_at',
        'created_at',
    ];

    protected $casts = [
        'ofic_estado' => 'boolean',
        'ofic_publico' => 'boolean',
    ];

    public $headers =  [
        ['text' => "ID", 'value' => "ofic_id", 'short' => false, 'order' => 'ASC'],
        ['text' => "Nombre", 'value' => "ofic_nombre", 'short' => false, 'order' => 'ASC'],
        ['text' => "Siglas", 'value' => "ofic_siglas", 'short' => false, 'order' => 'ASC'],
    ];
}
