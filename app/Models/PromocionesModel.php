<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Carbon\Carbon;

class PromocionesModel extends Model
{
    use HasFactory;

    protected $table = 'promociones';

    protected $fillable = [
        'empresa_id',
        'nombre',
        'tipo',
        'descuento_porcentaje',
        'minimo_servicios',
        'vigencia_desde',
        'vigencia_hasta',
        'activo',
    ];

    protected $casts = [
        'descuento_porcentaje' => 'integer',
        'minimo_servicios' => 'integer',
        'vigencia_desde' => 'date',
        'vigencia_hasta' => 'date',
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

    public function redenciones(): HasMany
    {
        return $this->hasMany(RedencionesPromocionModel::class, 'promocion_id');
    }

    // ==================== SCOPES ====================

    public function scopeActivas($query)
    {
        return $query->where('activo', true)
            ->where('vigencia_desde', '<=', Carbon::today())
            ->where('vigencia_hasta', '>=', Carbon::today());
    }

    public function scopeVigentes($query)
    {
        return $query->where('vigencia_desde', '<=', Carbon::today())
            ->where('vigencia_hasta', '>=', Carbon::today());
    }

    public function scopePorTipo($query, $tipo)
    {
        return $query->where('tipo', $tipo);
    }

    public function scopeCumpleaños($query)
    {
        return $query->where('tipo', 'cumpleanos');
    }

    // ==================== MÉTODOS ====================

    public function estaVigente(): bool
    {
        return $this->activo &&
               $this->vigencia_desde <= Carbon::today() &&
               $this->vigencia_hasta >= Carbon::today();
    }

    public function getDescuentoFormateadoAttribute(): string
    {
        return $this->descuento_porcentaje . '%';
    }

    public function getVigenciaLabelAttribute(): string
    {
        return $this->vigencia_desde->format('d/m/Y') . ' - ' . 
               $this->vigencia_hasta->format('d/m/Y');
    }
}