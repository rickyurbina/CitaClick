<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'empresa_id',
        'telefono',
    ];

    protected $hidden = [
        'password',
    ];

    public function empresa()
    {
        return $this->belongsTo(EmpresasModel::class);
    }

    // ---- Roles ----

    public function esAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function esEmpresa(): bool
    {
        return $this->role === 'empresa';
    }

    public function esColaborador(): bool
    {
        return $this->role === 'colaborador';
    }

    public function esRecepcionista(): bool
    {
        return $this->role === 'recepcionista';
    }

    // ---- Relaciones ----

    /** Empresa que este usuario es dueño (cuando role = empresa). */
    public function empresaPropia(): HasOne
    {
        return $this->hasOne(Empresa::class, 'user_id');
    }

    /** Empresa a la que pertenece (cuando role = colaborador o recepcionista). */
    public function empresa(): BelongsTo
    {
        return $this->belongsTo(Empresa::class, 'empresa_id');
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