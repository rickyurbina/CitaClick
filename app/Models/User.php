<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class User extends Authenticatable // implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'empresa_id',
        'telefono',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the user's initials
     */
    public function initials(): string
    {
        return Str::of($this->name)
            ->explode(' ')
            ->map(fn (string $name) => Str::of($name)->substr(0, 1))
            ->implode('');
    }

    // ---- Roles ----

    public function esAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function esEmpresa(): bool
    {
        return $this->role === 'empresa';
    }

    public function esColaborador(): bool
    {
        return $this->role === 'colaborador';
    }

    public function esRecepcionista(): bool
    {
        return $this->role === 'recepcionista';
    }

    // ---- Relaciones ----

    /** Empresa que este usuario es dueño (cuando role = empresa). */
    public function empresaPropia(): HasOne
    {
        return $this->hasOne(Empresa::class, 'user_id');
    }

    /** Empresa a la que pertenece (cuando role = colaborador o recepcionista). */
    public function empresa(): BelongsTo
    {
        return $this->belongsTo(Empresa::class, 'empresa_id');
    }

    /** Servicios que este colaborador puede prestar. */
    public function servicios(): BelongsToMany
    {
        return $this->belongsToMany(Servicio::class, 'colaborador_servicio');
    }

    /** Citas asignadas a este colaborador. */
    public function citasAsignadas(): HasMany
    {
        return $this->hasMany(Cita::class, 'colaborador_id');
    }
}