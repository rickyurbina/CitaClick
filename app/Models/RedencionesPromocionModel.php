<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RedencionesPromocionModel extends Model
{
    use HasFactory;

    protected $table = 'redenciones_promocion';

    public $timestamps = false;

    protected $fillable = [
        'empresa_id',
        'cliente_id',
        'promocion_id',
        'cita_id',
        'created_at',
    ];

    protected $casts = [
        'created_at' => 'datetime',
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

    public function promocion(): BelongsTo
    {
        return $this->belongsTo(PromocionesModel::class, 'promocion_id');
    }

    public function cita(): BelongsTo
    {
        return $this->belongsTo(CitasModel::class, 'cita_id');
    }
}