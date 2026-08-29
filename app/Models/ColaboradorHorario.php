<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ColaboradorHorario extends Model
{
    protected $table = 'colaborador_horarios';

    protected $fillable = [
        'colaborador_id',
        'configuracion',
    ];

    protected $casts = [
        'configuracion' => 'array',
    ];

    public function colaborador(): BelongsTo
    {
        return $this->belongsTo(User::class, 'colaborador_id');
    }
}