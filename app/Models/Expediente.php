<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Expediente extends Model
{
    use HasFactory;

    protected $primaryKey = 'expe_id';
    public $timestamps = true;

    protected $casts = [
        'expe_tipo' => 'string',
        'expe_origen' => 'boolean',
        'expe_numero' => 'integer',
        'expe_fecha_registro' => 'datetime',
        'expe_remi_tipo' => 'string',
        'expe_esta_id' => 'integer',
        'expe_proc_id' => 'integer',
        'expe_docu_id' => 'integer',
        'expe_admin_id' => 'integer',
        'expe_plazo' => 'integer',
        'expe_pers_id' => 'integer'
    ];

    protected $fillable = [
        'expe_codigo',
        'expe_password',
        'expe_origen',
        'expe_numero',
        'expe_periodo',
        'expe_sigla',
        'expe_tipo',
        'expe_asunto',
        'expe_resumen',
        'expe_folios',
        'expe_observacion',
        'expe_fecha_registro',
        'expe_plazo',
        'expe_remi_tipo',
        'expe_esta_id',
        'expe_proc_id',
        'expe_docu_id',
        'expe_admin_id',
        'expe_pers_id'
    ];

    public function estado()
    {
        return $this->belongsTo(Estado::class, 'expe_esta_id', 'esta_id');
    }

    public function proceso()
    {
        return $this->belongsTo(Proceso::class, 'expe_proc_id', 'proc_id');
    }

    public function documento()
    {
        return $this->belongsTo(Documento::class, 'expe_docu_id', 'docu_id');
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'expe_admin_id');
    }

    public function persona()
    {
        return $this->belongsTo(Persona::class, 'expe_pers_id', 'pers_id');
    }

    public function getNextNumDoc($doc, $tipo, $sigla)
    {
        $config = Configuracion::find(1);
        $periodo = $config->conf_periodo;
        $tipo = strtoupper($tipo);

        $origen  = $tipo === 'EXTERNO' ? 0 : 1;

        $res =  Expediente::where('expe_docu_id', $doc)
            ->where('expe_origen', $origen)
            ->where('expe_tipo', $tipo)
            ->where('expe_periodo', $periodo)
            ->where('expe_sigla', $sigla)
            ->max('expe_numero');

        return $res  + 1;
    }

    public function getSiglas(String $tipo, Admin $remitente = null): String
    {

        $admin = Auth::guard('admin')->user();

        $sigla = "";
        $siglas = [];

        if ($tipo === 'personal') {
            $_oficina = Oficina::select('ofic_siglas')->where('ofic_id', $admin->ofic_id)->first()->ofic_siglas;
            array_push($siglas, $_oficina, $this->getIniciales($admin->name));
        } else if ($tipo === 'jefatura') {
            $_oficina = Oficina::select('ofic_siglas')->where('ofic_id', $admin->ofic_id)->first()->ofic_siglas;
            array_push($siglas, $_oficina);
        }

        $sigla = implode('/', $siglas);
        return $sigla;
    }

    function getIniciales(String $string): String
    {
        $iniciales = '';
        $explode = explode(' ', $string);
        foreach ($explode as $val) {
            $iniciales .=  $val[0];
        }
        return $iniciales;
    }
}
