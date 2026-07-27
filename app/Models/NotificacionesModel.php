<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotificacionesModel extends Model
{
    protected $table = 'notificaciones';

    protected $fillable = [
        'empresa_id',
        'cita_id',
        'cliente_id',
        'tipo',
        'mensaje',
        'enviado',
        'fecha_envio'
    ];
}
