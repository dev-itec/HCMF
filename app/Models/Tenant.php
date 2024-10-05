<?php

namespace App\Models;

use Stancl\Tenancy\Database\Models\Tenant as BaseTenant;
use Stancl\Tenancy\Contracts\TenantWithDatabase;
use Stancl\Tenancy\Database\Concerns\HasDatabase;
use Stancl\Tenancy\Database\Concerns\HasDomains;

class Tenant extends BaseTenant implements TenantWithDatabase
{
    use HasDatabase, HasDomains;

    protected $fillable = ['id', 'name', 'email', 'password', 'api_key']; // Añadir 'api_key' aquí

    public static function getCustomColumns(): array
    {
        return [
            'id',
            'name',
            'email',
            'password',
            'api_key' // Añadir 'api_key' aquí
        ];
    }

    public function setPasswordAttribute($value)
    {
        return $this->attributes['password'] = bcrypt($value);
    }

    public function scopeWithDomain(Builder $query, string $domain): Builder
    {
        return $query->whereHas('domains', function($query) use ($domain) {
            $query->where('domain', $domain);
        });
    }
}

