<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UsersModel extends Model
{
    protected $table = 'users';

    protected $fillable = [
        'empresa_id',
        'nombre',
        'email',
        'password',
        'telefono',
        'rol',
        'comision_porcentaje',
        'horario_inicio',
        'horario_fin',
        'dias_descanso',
        'activo'
    ];
}
