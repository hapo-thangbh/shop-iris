<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    const ADMIN = 1;
    const EMPLOYEE = 2;
    const ACTIVE = 1;
    const DISABLE = 0;

    use Notifiable;
    protected $fillable = [
        'name', 'email', 'password', 'account', 'phone', 'level', 'is_active', 'address'
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
