<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class EmpresasModel extends Model
{
    use HasFactory;

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
        'config',
    ];

    protected $casts = [
        'config' => 'json',
        'fecha_vencimiento' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected $attributes = [
        'plan' => 'basico',
        'estatus' => 'prueba',
    ];

    // ==================== RELACIONES ====================

    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'empresa_id');
    }

    public function clientes(): HasMany
    {
        return $this->hasMany(ClientesModel::class, 'empresa_id');
    }

    public function servicios(): HasMany
    {
        return $this->hasMany(ServiciosModel::class, 'empresa_id');
    }

    public function citas(): HasMany
    {
        return $this->hasMany(CitasModel::class, 'empresa_id');
    }

    public function comisiones(): HasMany
    {
        return $this->hasMany(ComisionesModel::class, 'empresa_id');
    }

    public function promociones(): HasMany
    {
        return $this->hasMany(PromocionesModel::class, 'empresa_id');
    }

    public function listaEspera(): HasMany
    {
        return $this->hasMany(ListaEsperaModel::class, 'empresa_id');
    }

    public function notificaciones(): HasMany
    {
        return $this->hasMany(NotificacionesModel::class, 'empresa_id');
    }

    public function pagos(): HasMany
    {
        return $this->hasMany(PagoEmpresaModel::class, 'empresa_id');
    }

    public function redenciones(): HasMany
    {
        return $this->hasMany(RedencionesPromocionModel::class, 'empresa_id');
    }

    // ==================== SCOPES ====================

    public function scopeActivas($query)
    {
        return $query->where('estatus', 'activo');
    }

    public function scopeEnPrueba($query)
    {
        return $query->where('estatus', 'prueba');
    }

    public function scopeConPlan($query, $plan)
    {
        return $query->where('plan', $plan);
    }

    public function scopeVencidas($query)
    {
        return $query->where('fecha_vencimiento', '<', now())
            ->where('estatus', '!=', 'suspendido');
    }

    // ==================== MÉTODOS ====================

    public function estaActiva(): bool
    {
        return $this->estatus === 'activo';
    }

    public function estaEnPrueba(): bool
    {
        return $this->estatus === 'prueba';
    }

    public function estaVencida(): bool
    {
        return $this->fecha_vencimiento && $this->fecha_vencimiento->isPast();
    }

    public function generarSlug(): void
    {
        $this->slug = Str::slug($this->nombre) . '-' . Str::random(4);
    }

    public function getLogoSrcAttribute(): ?string
    {
        $value = $this->attributes['logo_url'] ?? null;

        if (!$value) {
            return null;
        }

        if (filter_var($value, FILTER_VALIDATE_URL)) {
            return $value;
        }

        // Normalizar por si quedó guardado con prefijo storage/
        $path = str_starts_with($value, 'storage/')
            ? substr($value, 8)
            : ltrim($value, '/');

        return asset('storage/' . $path);
    }

    public function getLogoPathAttribute(): ?string
    {
        return $this->attributes['logo_url'] ?? null;
    }

    // ==================== BOOT ====================

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($empresa) {
            if (empty($empresa->slug)) {
                $empresa->generarSlug();
            }
        });
    }
}