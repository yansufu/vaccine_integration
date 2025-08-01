<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vaccines extends Model
{
    use HasFactory;

    protected $table = 'vaccine';

    public $timestamps = false;

    protected $fillable = [
        'name',
        'cat_id',
        'period',
    ];
    
}
