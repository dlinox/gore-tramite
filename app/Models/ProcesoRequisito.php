<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProcesoRequisito extends Model
{
    use HasFactory;

    use HasFactory;

    protected $primaryKey = 'prre_id';

    protected $fillable = [
        'prre_nombre',
        'prre_descripcion',
        'prre_tipo_archivo',
        'prre_proc_id',
        'prre_activo',
    ];

    protected $hidden = [
        'updated_at',
        'created_at',
    ];

    protected $casts = [
        'requ_activo' => 'boolean',
    ];


    public function proceso()
    {
        return $this->belongsTo(Proceso::class, 'prre_proc_id', 'proc_id');
    }

    public $headers =  [
        ['text' => "ID", 'value' => "ofic_id", 'short' => false, 'order' => 'ASC'],
        ['text' => "Nombre", 'value' => "requ_nombre", 'short' => false, 'order' => 'ASC'],
        ['text' => "Tipo de Archivo", 'value' => "requ_tipo_archivo", 'short' => false, 'order' => 'ASC'],
        ['text' => "ACtivo", 'value' => "requ_activo", 'short' => false, 'order' => 'ASC'],
    ];

}
