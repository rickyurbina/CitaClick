<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Colaborador_ServicioModel extends Model
{
    protected $table = 'colaborador_servicio';

    protected $fillable = [
        'colaborador_id',
        'servicio_id'
    ];
}
