<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VacunatoryCenterVaccination extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'vaccine_id',
        'used_lots',
        'name',
        'locality_id',
        'received_lots',
    ];

    public function vacunatoryCenter()
    {
        return $this->hasMany('App\VacunatoryCenter', 'locality_id');
    }

    public function type_vaccine()
    {
        return $this->belongsToMany(TypeVaccine::class, 'vaccine_id');
    }

    public function localities()
    {
        return $this->belongsToMany(MunicipalityVaccination::class, 'mv_vc');
    }
}
