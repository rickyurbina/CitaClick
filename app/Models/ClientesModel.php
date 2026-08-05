<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Carbon\Carbon;

class ClientesModel extends Model
{
    use HasFactory;

    protected $table = 'clientes';

    protected $fillable = [
        'empresa_id',
        'telefono',
        'nombre',
        'fecha_nacimiento',
        'puntos_buenos',
        'puntos_malos',
        'bloqueado_hasta',
        'total_gastado',
    ];

    protected $casts = [
        'fecha_nacimiento' => 'date',
        'bloqueado_hasta' => 'date',
        'total_gastado' => 'decimal:2',
        'puntos_buenos' => 'integer',
        'puntos_malos' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected $attributes = [
        'puntos_buenos' => 0,
        'puntos_malos' => 0,
        'total_gastado' => 0,
    ];

    // ==================== RELACIONES ====================

    public function empresa(): BelongsTo
    {
        return $this->belongsTo(EmpresasModel::class, 'empresa_id');
    }

    public function citas(): HasMany
    {
        return $this->hasMany(CitasModel::class, 'cliente_id');
    }

    public function listaEspera(): HasMany
    {
        return $this->hasMany(ListaEsperaModel::class, 'cliente_id');
    }

    public function notificaciones(): HasMany
    {
        return $this->hasMany(NotificacionesModel::class, 'cliente_id');
    }

    public function redenciones(): HasMany
    {
        return $this->hasMany(RedencionesPromocionModel::class, 'cliente_id');
    }

    // ==================== SCOPES ====================

    public function scopeDeEmpresa($query, $empresaId)
    {
        return $query->where('empresa_id', $empresaId);
    }

    public function scopeBloqueados($query)
    {
        return $query->where('bloqueado_hasta', '>=', Carbon::today());
    }

    public function scopeNoBloqueados($query)
    {
        return $query->whereNull('bloqueado_hasta')
            ->orWhere('bloqueado_hasta', '<', Carbon::today());
    }

    public function scopeConPuntosBuenos($query, $minimo = 10)
    {
        return $query->where('puntos_buenos', '>=', $minimo);
    }

    public function scopeMayoresGastos($query, $limit = 10)
    {
        return $query->orderBy('total_gastado', 'desc')->limit($limit);
    }

    public function scopeConCumpleaños($query, $fecha = null)
    {
        $fecha = $fecha ?? Carbon::today();
        return $query->whereMonth('fecha_nacimiento', $fecha->month)
            ->whereDay('fecha_nacimiento', $fecha->day);
    }

    // ==================== MÉTODOS ====================

    public function estaBloqueado(): bool
    {
        return $this->bloqueado_hasta && $this->bloqueado_hasta->isFuture();
    }

    public function bloquear($dias = 30): void
    {
        $this->bloqueado_hasta = Carbon::today()->addDays($dias);
        $this->save();
    }

    public function desbloquear(): void
    {
        $this->bloqueado_hasta = null;
        $this->save();
    }

    public function sumarPuntosBuenos($puntos): void
    {
        $this->puntos_buenos += $puntos;
        $this->save();
    }

    public function sumarPuntosMalos($puntos): void
    {
        $this->puntos_malos += $puntos;
        $this->save();
    }

    public function sumarGasto($monto): void
    {
        $this->total_gastado += $monto;
        $this->save();
    }

    public function getTelefonoFormateadoAttribute(): string
    {
        // Formato: +52 123 456 7890
        $telefono = preg_replace('/[^0-9]/', '', $this->telefono);
        
        if (strlen($telefono) === 10) {
            return substr($telefono, 0, 3) . ' ' . 
                   substr($telefono, 3, 3) . ' ' . 
                   substr($telefono, 6, 4);
        }
        
        return $this->telefono;
    }

    public function getEstaBloqueadoAttribute(): bool
    {
        return $this->estaBloqueado();
    }

    public function getDiasBloqueadoAttribute(): ?int
    {
        if (!$this->bloqueado_hasta) {
            return null;
        }
        
        return Carbon::today()->diffInDays($this->bloqueado_hasta, false);
    }
}