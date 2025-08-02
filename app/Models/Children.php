<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Vaccinations;


class Children extends Model
{
    use HasFactory;

    protected $table = 'child';

    protected $primaryKey = 'childID';

    protected $fillable = [
        'parent_id',
        'name',
        'date_of_birth',
        'NIK',
        'gender',
        'weight',
        'height',
        'medical_history',
        'allergy',
        'org_id',
    ];

    public function organization()
    {
        return $this->belongsTo(Organizations::class, 'org_id');
    }


    public function vaccination()
    {
        return $this->hasMany(Vaccinations::class, 'child_id');
    }

}
