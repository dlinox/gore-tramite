<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proceso extends Model
{
    use HasFactory;

    protected $primaryKey = 'proc_id';

    protected $fillable = [
        'proc_nombre',
        'proc_docu_id',
        'proc_plazo',
        'proc_descripcion',
        'proc_activo',
    ];

    protected $hidden = [
        'updated_at',
        'created_at',
    ];

    protected $casts = [
        'proc_activo' => 'boolean',
    ];

    protected $with = ['documento', 'requisitos']; // Relación documento

    public function documento()
    {
        return $this->belongsTo(Documento::class, 'proc_docu_id', 'docu_id');
    }

     // Relación con el modelo ProcesoRequisito
     public function requisitos()
     {
         return $this->hasMany(ProcesoRequisito::class, 'prre_proc_id', 'proc_id');
     }


    public $headers =  [
        ['text' => "ID", 'value' => "proc_id", 'short' => false, 'order' => 'ASC'],
        ['text' => "Nombre", 'value' => "proc_nombre", 'short' => false, 'order' => 'ASC'],
        ['text' => "Plazo", 'value' => "proc_plazo", 'short' => false, 'order' => 'ASC'],
        ['text' => "Documento", 'value' => "documento", 'short' => false, 'order' => 'ASC'],
        ['text' => "Activo", 'value' => "proc_activo", 'short' => false, 'order' => 'ASC'],
    ];
}
