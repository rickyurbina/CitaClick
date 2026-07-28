<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'empresa_id', 'name', 'email', 'password',
    ];

    protected $hidden = [
        'password',
    ];

    public function empresa()
    {
        return $this->belongsTo(EmpresasModel::class);
    }
}
