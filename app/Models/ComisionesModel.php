<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class ComisionesModel extends Model
{
    use HasFactory;

    protected $table = 'comisiones';

    protected $fillable = [
        'empresa_id',
        'colaborador_id',
        'cita_id',
        'monto',
        'estatus',
        'fecha_pago',
    ];

    protected $casts = [
        'monto' => 'decimal:2',
        'fecha_pago' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected $attributes = [
        'estatus' => 'pendiente',
    ];

    // ==================== RELACIONES ====================

    public function empresa(): BelongsTo
    {
        return $this->belongsTo(EmpresasModel::class, 'empresa_id');
    }

    public function colaborador(): BelongsTo
    {
        return $this->belongsTo(User::class, 'colaborador_id');
    }

    public function cita(): BelongsTo
    {
        return $this->belongsTo(CitasModel::class, 'cita_id');
    }

    // ==================== SCOPES ====================

    public function scopePorEmpresa($query, $empresaId)
    {
        return $query->where('empresa_id', $empresaId);
    }

    public function scopePorColaborador($query, $colaboradorId)
    {
        return $query->where('colaborador_id', $colaboradorId);
    }

    public function scopePendientes($query)
    {
        return $query->where('estatus', 'pendiente');
    }

    public function scopePagadas($query)
    {
        return $query->where('estatus', 'pagada');
    }

    public function scopeDelDia($query)
    {
        return $query->whereDate('created_at', Carbon::today());
    }

    // ==================== MÉTODOS ====================

    public function marcarComoPagada(): void
    {
        $this->estatus = 'pagada';
        $this->fecha_pago = Carbon::today();
        $this->save();
    }

    public function marcarComoPendiente(): void
    {
        $this->estatus = 'pendiente';
        $this->fecha_pago = null;
        $this->save();
    }

    public function estaPagada(): bool
    {
        return $this->estatus === 'pagada';
    }

    public function getMontoFormateadoAttribute(): string
    {
        return '$' . number_format($this->monto, 2, ',', '.');
    }

    public function getEstatusColorAttribute(): string
    {
        return $this->estatus === 'pagada' ? 'green' : 'yellow';
    }
}