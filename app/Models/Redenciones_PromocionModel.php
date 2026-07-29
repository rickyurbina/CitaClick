<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Redenciones_PromocionModel extends Model
{
    protected $table = 'redenciones_promocion';

    protected $fillable = [
        'empresa_id',
        'cliente_id',
        'promocion_id',
        'cita_id'
    ];
}
