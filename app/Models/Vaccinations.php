<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vaccinations extends Model
{
    use HasFactory;

    protected $table = 'vaccination';

    protected $fillable = [
    'child_id',
    'prov_id',
    'vaccine_id',
    'lot_id',
    'location',
    'notes',
    'is_completed',
    ];

    public function child()
    {
        return $this->belongsTo(Children::class, 'child_id');
    }

    public function provider()
    {
        return $this->belongsTo(Providers::class, 'prov_id');
    }

    public function vaccine()
    {
        return $this->belongsTo(Vaccines::class, 'vaccine_id');
    }

}
