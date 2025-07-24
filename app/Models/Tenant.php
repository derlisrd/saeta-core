<?php

namespace App\Models;

use App\Models\Admin\User;
use Stancl\Tenancy\Database\Models\Tenant as BaseTenant;
use Stancl\Tenancy\Contracts\TenantWithDatabase;
use Stancl\Tenancy\Database\Concerns\HasDatabase;
use Stancl\Tenancy\Database\Concerns\HasDomains;

class Tenant extends BaseTenant implements TenantWithDatabase
{
    use HasDatabase, HasDomains;

    // Indica que la clave primaria no es un entero auto-incrementable
    public $incrementing = false;

    // Indica que la clave primaria es de tipo string
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'user_id',
        'data',
        'tenancy_db_name'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function getDataColumn(): string
    {
        return 'data';
    }
}
