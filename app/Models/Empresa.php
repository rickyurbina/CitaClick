<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Empresa extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nombre',
        'slug',
        'direccion',
        'telefono',
        'descripcion',
        'logo_path',
        'activa',
    ];

    protected function casts(): array
    {
        return [
            'activa' => 'boolean',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (Empresa $empresa) {
            if (empty($empresa->slug)) {
                $empresa->slug = Str::slug($empresa->nombre);
            }
        });
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /** Dueño de la empresa. */
    public function propietario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /** Colaboradores y recepcionistas que pertenecen a esta empresa. */
    public function colaboradores(): HasMany
    {
        return $this->hasMany(User::class, 'empresa_id')->where('role', 'colaborador');
    }

    public function recepcionistas(): HasMany
    {
        return $this->hasMany(User::class, 'empresa_id')->where('role', 'recepcionista');
    }

    public function servicios(): HasMany
    {
        return $this->hasMany(Servicio::class);
    }

    public function citas(): HasMany
    {
        return $this->hasMany(Cita::class);
    }
}