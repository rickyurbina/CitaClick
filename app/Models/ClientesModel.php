<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClientesModel extends Model
{
    protected $table = "clientes";

    protected $fillable = [
        'empresa_id',
        'telefono',
        'nombre',
        'fecha_nacimiento',
        'puntos_buenos',
        'puntos_malos',
        'bloqueado_hasta',
        'total_gastado'
    ];
}
