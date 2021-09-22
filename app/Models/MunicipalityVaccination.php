<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MunicipalityVaccination extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'complete_name',
        'iso_id',
        'province_id',
        'received_vaccines',
        'assigned_vaccines',
        'discarded_vaccines',
    ];

    public function municipality()
    {
        return $this->hasMany('App\Municipality', 'province_id');
    }

    public function regions()
    {
        return $this->belongsToMany(ProvinceVaccination::class, 'pv_mv');
    }

    public function type_vaccine()
    {
        return $this->belongsTo(TypeVaccine::class, 'vaccine_id');
    }

    public function vacunatories()
    {
        return $this->belongsToMany(VacunatoryCenterVaccination::class, 'mv_vc');
    }
}
