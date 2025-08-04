<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Auth\Passwords\CanResetPassword as CanResetPasswordTrait;
use Illuminate\Notifications\Notifiable;

class ProviderAuth extends Authenticatable implements CanResetPassword
{
    use CanResetPasswordTrait, Notifiable;

    protected $table = 'parent'; 

    protected $fillable = [
        'name',
        'NIK',
        'email',
        'password',
    ];
}
