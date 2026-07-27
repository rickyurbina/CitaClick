<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lista_EsperaModel extends Model
{
    protected $table = 'lista_espera';

    protected $fillable = [
        'empresa_id',
        'cliente_id',
        'servicio_id',
        'fecha_deseada',
        'hora_preferida',
        'estado'
    ];
}
