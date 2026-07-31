<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'nombre',
        'email',
        'password',
        'rol',
        'empresa_id',
        'telefono',
        'comision_porcentaje',
        'horario_inicio',
        'horario_fin',
        'dias_descanso',
        'activo',
    ];

    protected $hidden = [
        'password',
    ];

    // ---- Roles ----

    public function esSuperAdmin(): bool
    {
        return $this->rol === 'super_admin';
    }

    public function esEmpresaAdmin(): bool
    {
        return $this->rol === 'empresa_admin';
    }

    public function esColaborador(): bool
    {
        return $this->rol === 'colaborador';
    }

    public function esRecepcionista(): bool
    {
        return $this->rol === 'recepcionista';
    }

    // ---- Relaciones ----

    /** Empresa a la que pertenece este usuario. */
    public function empresa(): BelongsTo
    {
        return $this->belongsTo(EmpresasModel::class, 'empresa_id');
    }

    /** Servicios que este colaborador puede prestar. */
    public function servicios(): BelongsToMany
    {
        return $this->belongsToMany(Servicio::class, 'colaborador_servicio');
    }

    /** Citas asignadas a este colaborador. */
    public function citasAsignadas(): HasMany
    {
        return $this->hasMany(Cita::class, 'colaborador_id');
    }
}