<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Tramite extends Model
{
    use HasFactory;

    protected $primaryKey = 'tram_id';

    protected $fillable = [
        'tram_fecha_registro',
        'tram_notificar',
        'tram_fecha_recibido',
        'tram_fecha_tramitado',
        'tram_tram_padre',
        'tram_periodo',
        'tram_observacion',
        'tram_esta_id',
        'tram_expe_id',
        'tram_ofic_ini',
        'tram_ofic_fin',
        'tram_admin_ini',
        'tram_admin_fin',
        'tram_acci_id',
        'tram_docu_id',
    ];

    protected $casts = [
        'tram_notificar' => 'boolean',
        'tram_fecha_registro' => 'date',
        'tram_fecha_recibido' => 'date',
        'tram_fecha_tramitado' => 'date',
    ];

  



    public function expediente()
    {
        return $this->belongsTo(Expediente::class, 'tram_expe_id');
    }

    public function oficinaInicio()
    {
        return $this->belongsTo(Oficina::class, 'tram_ofic_ini');
    }

    public function oficinaFin()
    {
        return $this->belongsTo(Oficina::class, 'tram_ofic_fin');
    }

    public function administradorInicio()
    {
        return $this->belongsTo(Admin::class, 'tram_admin_ini');
    }

    public function administradorFin()
    {
        return $this->belongsTo(Admin::class, 'tram_admin_fin');
    }

    public function accion()
    {
        return $this->belongsTo(Accion::class, 'tram_acci_id');
    }

    
}
