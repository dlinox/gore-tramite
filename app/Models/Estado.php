<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estado extends Model
{
    use HasFactory;

    protected $primaryKey = 'esta_id';

    protected $fillable = [
        'esta_nombre',
        'esta_tipo',
    ];

    protected $hidden = [
        'updated_at',
        'created_at',
    ];
}
