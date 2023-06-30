<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Configuracion extends Model
{
    use HasFactory;
    protected $primaryKey = 'conf_id';
    protected $table = 'configuraciones';
    protected $fillable = [
        'conf_periodo',
    ];
}
