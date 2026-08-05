<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AuditoriaCitasModel extends Model
{
    use HasFactory;

    protected $table = 'auditoria_citas';

    public $timestamps = false;

    protected $fillable = [
        'cita_id',
        'usuario_id',
        'campo_modificado',
        'valor_anterior',
        'valor_nuevo',
        'created_at',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    // ==================== RELACIONES ====================

    public function cita(): BelongsTo
    {
        return $this->belongsTo(CitasModel::class, 'cita_id');
    }

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    // ==================== MÉTODOS ====================

    public static function registrarCambio($citaId, $usuarioId, $campo, $valorAnterior, $valorNuevo)
    {
        return self::create([
            'cita_id' => $citaId,
            'usuario_id' => $usuarioId,
            'campo_modificado' => $campo,
            'valor_anterior' => $valorAnterior,
            'valor_nuevo' => $valorNuevo,
        ]);
    }

    public function getFechaFormateadaAttribute(): string
    {
        return $this->created_at->format('d/m/Y H:i:s');
    }
}