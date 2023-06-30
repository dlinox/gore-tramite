<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Documento extends Model
{
    use HasFactory;

    protected $primaryKey = 'docu_id';

    protected $fillable = [
        'docu_nombre',
        'docu_descripcion',
        'docu_plantilla',
        'docu_recurso',
        'docu_activo',
    ];

    protected $hidden = [
        'updated_at',
        'created_at',
        // 'docu_plantilla'
    ];

    protected $casts = [
        'docu_recurso' => 'boolean',
        'docu_activo' => 'boolean',
    ];

    protected $appends = ['docu_plantilla_url', 'docu_plantilla_file'];

    public function getDocuPlantillaUrlAttribute()
    {
        $url  = null;
        if ($this->docu_plantilla) {
            $url  = Storage::disk('template')->url($this->docu_plantilla);
        }
        return $url;
    }

    public function getDocuPlantillaFileAttribute()
    {
        return null;
    }

    public $headers =  [
        ['text' => "ID", 'value' => "docu_id", 'short' => false, 'order' => 'ASC'],
        ['text' => "Nombre", 'value' => "docu_nombre", 'short' => false, 'order' => 'ASC'],
        ['text' => "Descripción", 'value' => "docu_descripcion", 'short' => false, 'order' => 'ASC'],
        ['text' => "Plantilla", 'value' => "docu_plantilla_url", 'short' => false, 'order' => 'ASC'],
        ['text' => "Recuros", 'value' => "docu_recurso", 'short' => false, 'order' => 'ASC'],
        ['text' => "Activo", 'value' => "docu_activo", 'short' => false, 'order' => 'ASC'],
    ];
}
