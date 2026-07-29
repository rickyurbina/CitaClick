<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PromocionesModel extends Model
{
    protected $table= 'promociones';

    protected $fillable = [
        'empresa_id',
        'nombre',
        'tipo',
        'descuento_porcentaje',
        'minimo_servicios',
        'vigencia_desde',
        'vigencia_hasta',
        'activo'
    ];
}
