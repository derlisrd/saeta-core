<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable, HasApiTokens;

    const TIPO_SUPER_ADMIN = 10;

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    protected $fillable = [
        'name',
        'empresa_id',
        'sucursal_id',
        'cliente_id',
        'username',
        'email',
        'password',
        'tipo',
        'activo',
        'cambiar_password',
        'hidden'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'email_verified_at',
        'created_at',
        'updated_at',
        'hidden'
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

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }

    public function sucursal()
    {
        return $this->belongsTo(Sucursal::class, 'sucursal_id');
    }
    public function permisos()
    {
        return $this->belongsToMany(Permiso::class, 'permisos_otorgados');
    }

    public function tienePermiso(string $modulo, string $accion): bool
    {
        return $this->permisos()->where('modulo', $modulo)->where('accion', $accion)->exists();
    }

    public function esSuperAdmin()
    {
        return $this->tipo === self::TIPO_SUPER_ADMIN;
    }
}
