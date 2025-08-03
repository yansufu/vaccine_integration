<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword as CanResetPasswordTrait;

class Parents extends Model
{
    use HasFactory;
    use CanResetPasswordTrait;

    protected $table = 'parent';

    protected $fillable = [
        'name',
        'NIK',
        'email',
        'password',
    ];
        
}  
