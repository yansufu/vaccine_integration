<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Catalogs extends Model
{
    use HasFactory; 

    protected $table = 'catalog';

    protected $fillable = [
        'org_id',
        'cat_id',
        'price',
        'vaccination_date',
    ];

    public function organization()
    {
        return $this->belongsTo(Organizations::class, 'org_id');
    }

    public function category()
    {
        return $this->belongsTo(Categories::class, 'cat_id');
    }
}
