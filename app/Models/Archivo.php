<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Archivo extends Model
{
    use HasFactory;
    
    protected $primaryKey = 'arch_id';
    
    protected $fillable = [
        'arch_nombre',
        'arch_path',
        'arch_extencion',
        'arch_tamanio',
        'arch_mimetype',
    ];
    
    protected $casts = [
        'arch_tamanio' => 'integer',
    ];
}
