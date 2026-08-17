<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'empresa_id',
        'nombre',
        'email',
        'password',
        'telefono',
        'foto_url',
        'rol',
        'comision_porcentaje',
        'horario_inicio',
        'horario_fin',
        'dias_descanso',
        'activo',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'dias_descanso' => 'array',
        'comision_porcentaje' => 'decimal:2',
        'activo' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected $attributes = [
        'activo' => true,
    ];

    // ==================== RELACIONES ====================

    public function empresa(): BelongsTo
    {
        return $this->belongsTo(EmpresasModel::class, 'empresa_id');
    }

    public function servicios(): BelongsToMany
    {
        return $this->belongsToMany(
            ServiciosModel::class,
            'colaborador_servicio',
            'colaborador_id',
            'servicio_id'
        );
    }

    public function citas(): HasMany
    {
        return $this->hasMany(CitasModel::class, 'colaborador_id');
    }

    public function citasAtendidas(): HasMany
    {
        return $this->hasMany(CitasModel::class, 'colaborador_id')
            ->where('estado', 'atendida');
    }

    public function comisiones(): HasMany
    {
        return $this->hasMany(ComisionesModel::class, 'colaborador_id');
    }

    public function auditorias(): HasMany
    {
        return $this->hasMany(AuditoriaCitasModel::class, 'usuario_id');
    }

    // ==================== SCOPES ====================

    public function scopeDeEmpresa($query, $empresaId)
    {
        return $query->where('empresa_id', $empresaId);
    }

    public function scopeActivos($query)
    {
        return $query->where('activo', true);
    }

    public function scopePorRol($query, $rol)
    {
        return $query->where('rol', $rol);
    }

    public function scopeColaboradores($query)
    {
        return $query->where('rol', 'colaborador');
    }

    public function scopeRecepcionistas($query)
    {
        return $query->where('rol', 'recepcionista');
    }

    public function scopeAdmins($query)
    {
        return $query->whereIn('rol', ['empresa_admin', 'super_admin']);
    }

    // ==================== MÉTODOS ====================

    public function esAdmin(): bool
    {
        return in_array($this->rol, ['empresa_admin', 'super_admin']);
    }

    public function esSuperAdmin(): bool
    {
        return $this->rol === 'super_admin';
    }

    public function esEmpresaAdmin(): bool
    {
        return $this->rol === 'empresa_admin';
    }

    public function esRecepcionista(): bool
    {
        return $this->rol === 'recepcionista';
    }

    public function esColaborador(): bool
    {
        return $this->rol === 'colaborador';
    }

    public function puedeGestionarCitas(): bool
    {
        return in_array($this->rol, ['empresa_admin', 'recepcionista', 'colaborador']);
    }

    public function puedeGestionarUsuarios(): bool
    {
        return $this->esAdmin();
    }

    public function puedeVerFinanzas(): bool
    {
        return $this->esAdmin() || $this->esRecepcionista();
    }

    public function getFotoSrcAttribute(): ?string
    {
        $value = $this->attributes['foto_url'] ?? null;

        if (!$value) {
            return null;
        }

        if (filter_var($value, FILTER_VALIDATE_URL)) {
            return $value;
        }

        $path = str_starts_with($value, 'storage/')
            ? substr($value, 8)
            : ltrim($value, '/');

        return asset('storage/' . $path);
    }

    public function getNombreCompletoAttribute(): string
    {
        return $this->nombre;
    }

    public function getRolLabelAttribute(): string
    {
        $labels = [
            'super_admin' => 'Super Administrador',
            'empresa_admin' => 'Administrador',
            'recepcionista' => 'Recepcionista',
            'colaborador' => 'Colaborador',
        ];

        return $labels[$this->rol] ?? $this->rol;
    }

    public function getRolColorAttribute(): string
    {
        $colors = [
            'super_admin' => 'red',
            'empresa_admin' => 'blue',
            'recepcionista' => 'green',
            'colaborador' => 'purple',
        ];

        return $colors[$this->rol] ?? 'gray';
    }

    public function getRolBadgeAttribute(): string
    {
        $colors = [
            'super_admin' => 'bg-red-100 text-red-800',
            'empresa_admin' => 'bg-blue-100 text-blue-800',
            'recepcionista' => 'bg-green-100 text-green-800',
            'colaborador' => 'bg-purple-100 text-purple-800',
        ];

        $color = $colors[$this->rol] ?? 'bg-gray-100 text-gray-800';
        
        return '<span class="px-2 py-1 text-xs rounded-full ' . $color . '">' 
               . $this->rol_label . '</span>';
    }

    public function getComisionPorcentajeFormateadoAttribute(): string
    {
        return $this->comision_porcentaje . '%';
    }
}