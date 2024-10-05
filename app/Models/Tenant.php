<?php

namespace App\Models;

use Stancl\Tenancy\Database\Models\Tenant as BaseTenant;
use Stancl\Tenancy\Contracts\TenantWithDatabase;
use Stancl\Tenancy\Database\Concerns\HasDatabase;
use Stancl\Tenancy\Database\Concerns\HasDomains;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;

class Tenant extends BaseTenant implements TenantWithDatabase, AuthenticatableContract
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
        // return $this->attributes['password'] = bcrypt($value); 
        return $this->attributes['password'] = $value;
    }

    public function scopeWithDomain(Builder $query, string $domain): Builder
    {
        return $query->whereHas('domains', function($query) use ($domain) {
            $query->where('domain', $domain);
        });
    }

    public function getAuthIdentifierName()
    {
        return $this->getKeyName();
    }

    public function getAuthIdentifier()
    {
        return $this->{$this->getAuthIdentifierName()};
    }

    public function getAuthPassword()
    {
        return $this->password;
    }

    public function getRememberToken()
    {
        return $this->remember_token;
    }

    public function setRememberToken($value)
    {
        $this->remember_token = $value;
    }

    public function getRememberTokenName()
    {
        return 'remember_token';
    }
}

