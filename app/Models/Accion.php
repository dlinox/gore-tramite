<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Accion extends Model
{
    use HasFactory;

    protected $table = 'acciones';
    protected $primaryKey = 'acci_id';

    protected $fillable = [
        'acci_nombre',
        'acci_obligatorio',
    ];

    protected $hidden = [
        'updated_at',
        'created_at',
    ];

    protected $casts = [
        'acci_obligatorio' => 'boolean',
    ];

    public $headers =  [
        ['text' => "ID", 'value' => "acci_id", 'short' => false, 'order' => 'ASC'],
        ['text' => "Nombre", 'value' => "acci_nombre", 'short' => false, 'order' => 'ASC'],
    ];
}
