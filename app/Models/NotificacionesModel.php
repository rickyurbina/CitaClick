<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NotificacionesModel extends Model
{
    use HasFactory;

    protected $table = 'notificaciones';

    public $timestamps = false;

    protected $fillable = [
        'empresa_id',
        'cita_id',
        'cliente_id',
        'tipo',
        'mensaje',
        'enviado',
        'fecha_envio',
        'created_at',
    ];

    protected $casts = [
        'enviado' => 'boolean',
        'fecha_envio' => 'datetime',
        'created_at' => 'datetime',
    ];

    protected $attributes = [
        'enviado' => false,
    ];

    // ==================== RELACIONES ====================

    public function empresa(): BelongsTo
    {
        return $this->belongsTo(EmpresasModel::class, 'empresa_id');
    }

    public function cita(): BelongsTo
    {
        return $this->belongsTo(CitasModel::class, 'cita_id');
    }

    public function cliente(): BelongsTo
    {
        return $this->belongsTo(ClientesModel::class, 'cliente_id');
    }

    // ==================== SCOPES ====================

    public function scopeNoEnviadas($query)
    {
        return $query->where('enviado', false);
    }

    public function scopeEnviadas($query)
    {
        return $query->where('enviado', true);
    }

    public function scopePorTipo($query, $tipo)
    {
        return $query->where('tipo', $tipo);
    }

    // ==================== MÉTODOS ====================

    public function marcarEnviada(): void
    {
        $this->enviado = true;
        $this->fecha_envio = now();
        $this->save();
    }

    public function getTipoLabelAttribute(): string
    {
        $labels = [
            'recordatorio' => 'Recordatorio',
            'cancelacion' => 'Cancelación',
            'confirmacion' => 'Confirmación',
            'promocion' => 'Promoción',
        ];

        return $labels[$this->tipo] ?? $this->tipo;
    }
}