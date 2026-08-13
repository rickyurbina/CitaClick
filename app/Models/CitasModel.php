<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class CitasModel extends Model
{
    use HasFactory;

    protected $table = 'citas';

    protected $fillable = [
        'empresa_id',
        'cliente_id',
        'colaborador_id',
        'servicio_id',
        'fecha',
        'hora_inicio',
        'hora_fin',
        'nombre_acompanante',
        'estado',
        'monto_pagado',
        'metodo_pago',
        'pagado',
        'fecha_pago',
        'cobrado_por',
        'checkin_time',
        'checkout_time',
        'motivo_cancelacion',
        'cancelada_por',
    ];

    protected $casts = [
        'fecha' => 'date',
        'hora_inicio' => 'datetime:H:i',
        'hora_fin' => 'datetime:H:i',
        'monto_pagado' => 'decimal:2',
        'pagado' => 'boolean',
        'fecha_pago' => 'datetime',
        'checkin_time' => 'datetime',
        'checkout_time' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected $attributes = [
        'estado' => 'agendada',
        'pagado' => false,
    ];

    // ==================== RELACIONES ====================

    public function empresa(): BelongsTo
    {
        return $this->belongsTo(EmpresasModel::class, 'empresa_id');
    }

    public function cliente(): BelongsTo
    {
        return $this->belongsTo(ClientesModel::class, 'cliente_id');
    }

    public function colaborador(): BelongsTo
    {
        return $this->belongsTo(User::class, 'colaborador_id');
    }

    public function servicio(): BelongsTo
    {
        return $this->belongsTo(ServiciosModel::class, 'servicio_id');
    }

    public function cobradoPor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'cobrado_por');
    }

    public function comision(): HasOne
    {
        return $this->hasOne(ComisionesModel::class, 'cita_id');
    }

    public function auditorias(): HasMany
    {
        return $this->hasMany(AuditoriaCitasModel::class, 'cita_id');
    }

    public function redenciones(): HasMany
    {
        return $this->hasMany(RedencionesPromocionModel::class, 'cita_id');
    }

    // ==================== SCOPES ====================

    public function scopeDeEmpresa($query, $empresaId)
    {
        return $query->where('empresa_id', $empresaId);
    }

    public function scopeDeColaborador($query, $colaboradorId)
    {
        return $query->where('colaborador_id', $colaboradorId);
    }

    public function scopeDelDia($query, $fecha = null)
    {
        $fecha = $fecha ?? Carbon::today();
        return $query->whereDate('fecha', $fecha);
    }

    public function scopeEntreFechas($query, $inicio, $fin)
    {
        return $query->whereBetween('fecha', [
            Carbon::parse($inicio),
            Carbon::parse($fin)
        ]);
    }

    public function scopePorEstado($query, $estado)
    {
        return $query->where('estado', $estado);
    }

    public function scopePorCliente($query, $clienteId)
    {
        return $query->where('cliente_id', $clienteId);
    }

    public function scopePagadas($query)
    {
        return $query->where('pagado', true);
    }

    public function scopeNoPagadas($query)
    {
        return $query->where('pagado', false);
    }

    public function scopePorMetodoPago($query, $metodo)
    {
        return $query->where('metodo_pago', $metodo);
    }

    public function scopeConfirmadas($query)
    {
        return $query->where('estado', 'confirmada');
    }

    public function scopePendientes($query)
    {
        return $query->whereIn('estado', ['agendada', 'confirmada']);
    }

    public function scopeFinalizadas($query)
    {
        return $query->whereIn('estado', ['atendida', 'cancelada', 'no_asistio']);
    }

    public function scopeEnCurso($query)
    {
        return $query->where('estado', 'en_curso');
    }

    // ==================== MÉTODOS CHECK IN/OUT ====================

    public function marcarCheckin(): void
    {
        $this->estado = 'en_curso';
        $this->checkin_time = now();
        $this->save();
    }

    public function marcarCheckout(): void
    {
        $this->estado = 'atendida';
        $this->checkout_time = now();
        $this->save();
    }

    // ==================== MÉTODOS CANCELACIÓN ====================

    public function puedeCancelar($rol = null): bool
    {
        // Admin, super_admin y recepcionista pueden cancelar siempre
        if (in_array($rol, ['empresa_admin', 'super_admin', 'recepcionista'])) {
            return true;
        }

        // Cliente y colaborador solo 24 horas antes
        if (in_array($rol, ['cliente', 'colaborador'])) {
            $horaCita = Carbon::parse($this->fecha . ' ' . $this->hora_inicio);
            return now()->diffInHours($horaCita, false) >= 24;
        }

        return false;
    }

    public function cancelar($motivo = null, $canceladoPor = null): void
    {
        $this->estado = 'cancelada';
        $this->motivo_cancelacion = $motivo;
        $this->cancelada_por = $canceladoPor ?? 'cliente';
        $this->save();

        // Sumar puntos negativos al cliente (solo si canceló el cliente)
        if ($canceladoPor === 'cliente') {
            $cliente = ClientesModel::find($this->cliente_id);
            if ($cliente) {
                $cliente->sumarPuntosMalos(2);
                if ($cliente->puntos_malos >= 5) {
                    $cliente->bloquear(15);
                }
            }
        }
    }

    // ==================== MÉTODOS ====================

    public function estaPagada(): bool
    {
        return $this->pagado && $this->monto_pagado > 0;
    }

    public function estaCancelada(): bool
    {
        return $this->estado === 'cancelada';
    }

    public function estaAtendida(): bool
    {
        return $this->estado === 'atendida';
    }

    public function estaConfirmada(): bool
    {
        return $this->estado === 'confirmada';
    }

    public function estaEnCurso(): bool
    {
        return $this->estado === 'en_curso';
    }

    public function estaAgendada(): bool
    {
        return $this->estado === 'agendada';
    }

    public function marcarPagada($monto = null, $metodo = null): void
    {
        $this->pagado = true;
        
        if ($monto) {
            $this->monto_pagado = $monto;
        }
        
        if ($metodo) {
            $this->metodo_pago = $metodo;
        }
        
        $this->fecha_pago = now();
        
        if (Auth::check()) {
            $this->cobrado_por = Auth::id();
        }
        
        $this->save();
    }

    public function getMontoFormateadoAttribute(): string
    {
        return '$' . number_format($this->monto_pagado ?? 0, 2, ',', '.');
    }

    public function getEstadoColorAttribute(): string
    {
        $colors = [
            'agendada' => 'yellow',
            'confirmada' => 'blue',
            'en_curso' => 'purple',
            'atendida' => 'green',
            'cancelada' => 'red',
            'no_asistio' => 'gray',
        ];

        return $colors[$this->estado] ?? 'gray';
    }

    public function getEstadoBadgeAttribute(): string
    {
        $colors = [
            'agendada' => 'bg-yellow-100 text-yellow-800',
            'confirmada' => 'bg-blue-100 text-blue-800',
            'en_curso' => 'bg-purple-100 text-purple-800',
            'atendida' => 'bg-green-100 text-green-800',
            'cancelada' => 'bg-red-100 text-red-800',
            'no_asistio' => 'bg-gray-100 text-gray-800',
        ];

        $color = $colors[$this->estado] ?? 'bg-gray-100 text-gray-800';
        
        return '<span class="px-2 py-1 text-xs rounded-full ' . $color . '">' 
               . ucfirst(str_replace('_', ' ', $this->estado)) . '</span>';
    }

    public function getDuracionAttribute(): string
    {
        return $this->hora_inicio . ' - ' . $this->hora_fin;
    }

    public function getCobradoPorNombreAttribute(): ?string
    {
        if (!$this->cobrado_por) {
            return null;
        }
        
        $usuario = User::find($this->cobrado_por);
        return $usuario ? $usuario->nombre : null;
    }

    // ==================== BOOT ====================

    protected static function boot()
    {
        parent::boot();

        static::created(function ($cita) {
            if ($cita->servicio && $cita->servicio->puntos_genera > 0) {
                $cliente = ClientesModel::find($cita->cliente_id);
                if ($cliente) {
                    $cliente->sumarPuntosBuenos($cita->servicio->puntos_genera);
                }
            }
        });

        static::updated(function ($cita) {
            if ($cita->estado === 'atendida' && $cita->pagado && !$cita->comision) {
                // La comisión se genera automáticamente por el Observer o Event
            }
        });
    }
}