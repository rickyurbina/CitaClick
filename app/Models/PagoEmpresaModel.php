<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class PagoEmpresaModel extends Model
{
    use HasFactory;

    protected $table = 'pagos_empresa';

    protected $fillable = [
        'empresa_id',
        'plan',
        'monto',
        'fecha_pago',
        'fecha_vencimiento',
        'metodo_pago',
        'referencia',
        'estatus',
    ];

    protected $casts = [
        'monto' => 'decimal:2',
        'fecha_pago' => 'date',
        'fecha_vencimiento' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected $attributes = [
        'estatus' => 'pagado',
    ];

    public function empresa(): BelongsTo
    {
        return $this->belongsTo(EmpresasModel::class, 'empresa_id');
    }

    public function scopePagados($query)
    {
        return $query->where('estatus', 'pagado');
    }

    public function scopePendientes($query)
    {
        return $query->where('estatus', 'pendiente');
    }

    public function scopeFallidos($query)
    {
        return $query->where('estatus', 'fallido');
    }

    public function scopePorEmpresa($query, $empresaId)
    {
        return $query->where('empresa_id', $empresaId);
    }

    public function scopePorPlan($query, $plan)
    {
        return $query->where('plan', $plan);
    }

    public function scopeVencidos($query)
    {
        return $query->where('fecha_vencimiento', '<', Carbon::today());
    }

    public function scopeEntreFechas($query, $desde, $hasta)
    {
        return $query->whereBetween('fecha_pago', [Carbon::parse($desde), Carbon::parse($hasta)]);
    }

    public function getMontoFormateadoAttribute(): string
    {
        return '$' . number_format($this->monto, 2);
    }

    public function getFechaPagoFormateadaAttribute(): string
    {
        return $this->fecha_pago->format('d/m/Y');
    }

    public function getFechaVencimientoFormateadaAttribute(): string
    {
        return $this->fecha_vencimiento->format('d/m/Y');
    }

    public function getPlanLabelAttribute(): string
    {
        return ucfirst($this->plan);
    }

    public function getEstatusColorAttribute(): string
    {
        return match ($this->estatus) {
            'pagado'    => 'success',
            'pendiente' => 'warning',
            'fallido'   => 'danger',
            default     => 'secondary',
        };
    }

    public function getEstatusBadgeAttribute(): string
    {
        $colors = [
            'pagado'    => 'bg-green-100 text-green-800',
            'pendiente' => 'bg-yellow-100 text-yellow-800',
            'fallido'   => 'bg-red-100 text-red-800',
        ];

        $color = $colors[$this->estatus] ?? 'bg-gray-100 text-gray-800';

        return '<span class="px-2 py-1 text-xs rounded-full ' . $color . '">' . ucfirst($this->estatus) . '</span>';
    }

    /**
     * Actualiza la empresa asociada con el plan y fecha de vencimiento del pago.
     * Si la empresa estaba inactiva o suspendida, la reactiva.
     */
    public function actualizarEmpresa(): void
    {
        $empresa = $this->empresa;
        if (!$empresa) {
            return;
        }

        $empresa->plan = $this->plan;
        $empresa->fecha_vencimiento = $this->fecha_vencimiento;

        if ($this->estatus === 'pagado' && in_array($empresa->estatus, ['inactivo', 'suspendido'])) {
            $empresa->estatus = 'activo';
        }

        $empresa->save();
    }

    protected static function boot()
    {
        parent::boot();

        static::created(function ($pago) {
            if ($pago->estatus === 'pagado') {
                $pago->actualizarEmpresa();
            }
        });

        static::updated(function ($pago) {
            if ($pago->estatus === 'pagado') {
                $pago->actualizarEmpresa();
            }
        });
    }
}
