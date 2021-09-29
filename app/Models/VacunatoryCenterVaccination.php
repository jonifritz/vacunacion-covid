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
        return $this->belongsTo(VacunatoryCenter::class);
    }

    public function type_vaccine()
    {
        return $this->belongsTo(TypeVaccine::class, 'vaccine_id');
    }

    public function localities()
    {
        return $this->belongsToMany(MunicipalityVaccination::class, 'mv_vc');
    }

    public function locality()
    {
        return $this->belongsTo(MunicipalityVaccination::class, 'locality_id');
    }

    public function vacunatory()
    {
        return $this->hasMany('App\Vacunatory', 'locality_id');
    }
}
