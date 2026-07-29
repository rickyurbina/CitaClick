<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmpresasModel extends Model
{
    protected $table = 'empresas';

    protected $fillable = [
        'slug',
        'nombre',
        'logo_url',
        'email_contacto',
        'telefono',
        'plan',
        'estatus',
        'fecha_vencimiento',
        'config'];
}
