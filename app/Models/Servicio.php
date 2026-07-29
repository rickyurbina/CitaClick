<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Servicio extends Model
{
    use HasFactory;

    protected $fillable = [
        'empresa_id',
        'nombre',
        'descripcion',
        'precio',
        'duracion_minutos',
        'activo',
    ];

    protected function casts(): array
    {
        return [
            'activo' => 'boolean',
            'precio' => 'decimal:2',
        ];
    }

    public function empresa(): BelongsTo
    {
        return $this->belongsTo(Empresa::class);
    }

    /** Colaboradores capacitados para prestar este servicio. */
    public function colaboradores(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'colaborador_servicio');
    }

    public function citas(): HasMany
    {
        return $this->hasMany(Cita::class);
    }
}