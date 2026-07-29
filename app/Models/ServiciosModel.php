<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiciosModel extends Model
{
    protected $table = 'servicios';

    protected $fillable = [
        'empresa_id',
        'nombre',
        'duracion_minutos',
        'precio',
        'puntos_genera',
        'activo'
    ];
}