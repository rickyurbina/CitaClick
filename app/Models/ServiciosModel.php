<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ServiciosModel extends Model
{
    use HasFactory;

    protected $table = 'servicios';

    protected $fillable = [
        'empresa_id',
        'nombre',
        'duracion_minutos',
        'precio',
        'puntos_genera',
        'activo',
    ];

    protected $casts = [
        'precio' => 'decimal:2',
        'duracion_minutos' => 'integer',
        'puntos_genera' => 'integer',
        'activo' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected $attributes = [
        'duracion_minutos' => 30,
        'puntos_genera' => 10,
        'activo' => true,
    ];

    // ==================== RELACIONES ====================

    public function empresa(): BelongsTo
    {
        return $this->belongsTo(EmpresasModel::class, 'empresa_id');
    }

    public function colaboradores(): BelongsToMany
    {
        return $this->belongsToMany(
            User::class,
            'colaborador_servicio',
            'servicio_id',
            'colaborador_id'
        );
    }

    public function citas(): HasMany
    {
        return $this->hasMany(CitasModel::class, 'servicio_id');
    }

    public function listaEspera(): HasMany
    {
        return $this->hasMany(ListaEsperaModel::class, 'servicio_id');
    }

    public function promociones(): HasMany
    {
        return $this->hasMany(PromocionesModel::class, 'servicio_id');
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

    public function scopeInactivos($query)
    {
        return $query->where('activo', false);
    }

    public function scopePorPrecio($query, $min = null, $max = null)
    {
        if ($min) {
            $query->where('precio', '>=', $min);
        }
        
        if ($max) {
            $query->where('precio', '<=', $max);
        }
        
        return $query;
    }

    // ==================== MÉTODOS ====================

    public function estaActivo(): bool
    {
        return $this->activo;
    }

    public function activar(): void
    {
        $this->activo = true;
        $this->save();
    }

    public function desactivar(): void
    {
        $this->activo = false;
        $this->save();
    }

    public function getPrecioFormateadoAttribute(): string
    {
        return '$' . number_format($this->precio, 2, ',', '.');
    }

    public function getDuracionLabelAttribute(): string
    {
        $minutos = $this->duracion_minutos;
        
        if ($minutos >= 60) {
            $horas = floor($minutos / 60);
            $resto = $minutos % 60;
            return $horas . 'h' . ($resto > 0 ? ' ' . $resto . 'min' : '');
        }
        
        return $minutos . ' min';
    }

    public function getTieneColaboradoresAttribute(): bool
    {
        return $this->colaboradores()->count() > 0;
    }
}