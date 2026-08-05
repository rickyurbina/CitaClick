<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ColaboradorServicioModel extends Model
{
    use HasFactory;

    protected $table = 'colaborador_servicio';

    public $timestamps = false;

    protected $fillable = [
        'colaborador_id',
        'servicio_id',
    ];

    // ==================== RELACIONES ====================

    public function colaborador(): BelongsTo
    {
        return $this->belongsTo(User::class, 'colaborador_id');
    }

    public function servicio(): BelongsTo
    {
        return $this->belongsTo(ServiciosModel::class, 'servicio_id');
    }
}