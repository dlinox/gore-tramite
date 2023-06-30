<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpedienteArchivo extends Model
{

    protected $primaryKey = 'exar_id';

    protected $fillable = [
        'exar_tipo',
        'exar_url',
        'exar_expe_id',
        'exar_arch_id',
    ];

    public function expediente()
    {
        return $this->belongsTo(Expediente::class, 'exar_expe_id', 'expe_id');
    }

    public function archivo()
    {
        return $this->belongsTo(Archivo::class, 'exar_arch_id', 'arch_id');
    }
}
