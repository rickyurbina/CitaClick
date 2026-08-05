<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ListaEsperaModel extends Model
{
    use HasFactory;

    protected $table = 'lista_espera';

    public $timestamps = false;

    protected $fillable = [
        'empresa_id',
        'cliente_id',
        'servicio_id',
        'fecha_deseada',
        'hora_preferida',
        'estado',
        'created_at',
    ];

    protected $casts = [
        'fecha_deseada' => 'date',
        'hora_preferida' => 'datetime:H:i',
        'created_at' => 'datetime',
    ];

    protected $attributes = [
        'estado' => 'esperando',
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

    public function servicio(): BelongsTo
    {
        return $this->belongsTo(ServiciosModel::class, 'servicio_id');
    }

    // ==================== SCOPES ====================

    public function scopeEsperando($query)
    {
        return $query->where('estado', 'esperando');
    }

    public function scopeNotificados($query)
    {
        return $query->where('estado', 'notificado');
    }

    // ==================== MÉTODOS ====================

    public function marcarNotificado(): void
    {
        $this->estado = 'notificado';
        $this->save();
    }

    public function marcarAtendido(): void
    {
        $this->estado = 'atendido';
        $this->save();
    }

    public function marcarCancelado(): void
    {
        $this->estado = 'cancelado';
        $this->save();
    }
}