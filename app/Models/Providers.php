<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Providers extends Model
{
    use HasFactory;

    protected $table = 'provider';

    protected $fillable = [
        'name',
        'org_id',
        'email',
        'password',
    ];

    public function organization()
        {
            return $this->belongsTo(Organizations::class, 'org_id');
        }

}
