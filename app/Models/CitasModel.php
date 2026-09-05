<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Auth;

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
        'fecha' => 'date:Y-m-d',
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
        $fecha = $fecha ?? date('Y-m-d');
        return $query->whereDate('fecha', $fecha);
    }

    public function scopeEntreFechas($query, $inicio, $fin)
    {
        return $query->whereBetween('fecha', [
            date('Y-m-d', strtotime($inicio)),
            date('Y-m-d', strtotime($fin))
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
        $this->checkin_time = date('Y-m-d H:i:s');
        $this->save();
    }

    public function marcarCheckout(): void
    {
        $this->estado = 'atendida';
        $this->checkout_time = date('Y-m-d H:i:s');
        $this->save();
    }

    // ==================== MÉTODO CANCELACIÓN (SIN CARBON) ====================

    /**
     * Verifica si la cita puede ser cancelada según el rol y el tiempo restante.
     *
     * @param string|null $rol
     * @return bool
     */
    public function puedeCancelar($rol = null): bool
    {
        // Admin, super_admin y recepcionista pueden cancelar siempre
        if (in_array($rol, ['empresa_admin', 'super_admin', 'recepcionista'])) {
            return true;
        }

        // Cliente y colaborador solo 24 horas antes
        if (in_array($rol, ['cliente', 'colaborador'])) {
            // Obtener fecha y hora como strings
            $fechaStr = $this->normalizarFecha($this->fecha);
            $horaStr = $this->normalizarHora($this->hora_inicio);

            // Si no se pudieron normalizar, retornar false
            if (!$fechaStr || !$horaStr || !strtotime($fechaStr) || !strtotime($horaStr)) {
                return false;
            }

            // Crear timestamp de la cita
            $timestampCita = strtotime($fechaStr . ' ' . $horaStr);
            $ahora = time();

            // Calcular diferencia en horas (negativo si ya pasó)
            $diferenciaHoras = ($timestampCita - $ahora) / 3600;

            return $diferenciaHoras >= 24;
        }

        return false;
    }

    /**
     * Normaliza una fecha a string Y-m-d.
     */
    private function normalizarFecha($fecha): ?string
    {
        if (!$fecha) {
            return null;
        }

        if ($fecha instanceof \DateTime) {
            return $fecha->format('Y-m-d');
        }

        if (is_object($fecha) && method_exists($fecha, 'format')) {
            return $fecha->format('Y-m-d');
        }

        if (is_string($fecha) && strtotime($fecha)) {
            return date('Y-m-d', strtotime($fecha));
        }

        return null;
    }

    /**
     * Normaliza una hora a string H:i.
     */
    private function normalizarHora($hora): ?string
    {
        if (!$hora) {
            return null;
        }

        if ($hora instanceof \DateTime) {
            return $hora->format('H:i');
        }

        if (is_object($hora) && method_exists($hora, 'format')) {
            return $hora->format('H:i');
        }

        if (is_string($hora) && strtotime($hora)) {
            return date('H:i', strtotime($hora));
        }

        return null;
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
        
        $this->fecha_pago = date('Y-m-d H:i:s');
        
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
        $inicio = $this->normalizarHora($this->hora_inicio);
        $fin = $this->normalizarHora($this->hora_fin);
        return ($inicio ?: '') . ' - ' . ($fin ?: '');
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

        // La comisión se genera automáticamente por el Observer o Event
    }
}