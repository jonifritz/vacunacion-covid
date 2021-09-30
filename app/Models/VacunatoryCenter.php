<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VacunatoryCenter extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'locality_id',
    ];

    public function locality()
    {
        return $this->belongsTo(MunicipalityVaccination::class, 'locality_id');
    }
}
