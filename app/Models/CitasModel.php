<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CitasModel extends Model
{
    protected $table = 'citas';

    protected $fillable = [
        'empresa_id',
        'cliente_id',
        'colaborador_id',
        'servicio_id',
        'fecha',
        'hora_inicio',
        'hora_fin',
        'nombre_acompanante',
        'estado',
        'monto_pagado',
        'metodo_pago',
        'pagado',
        'fecha_pago',
        'cobrado_por',
        'chekin_time',
        'chekout_time',
        'motivo_cancelacion',
        'cancelada_por'
    ];
}
