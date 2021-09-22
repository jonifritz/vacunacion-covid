<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProvinceVaccination extends Model
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
        'received_vaccines',
        'assigned_vaccines',
        'discarded_vaccines',
    ];

    public function type_vaccine()
    {
        return $this->belongsTo(TypeVaccine::class, 'vaccine_id');
    }

    public function vaccine_lots()
    {
        return $this->belongsToMany(VaccineLot::class, 'vl_pv');
    }

    public function localities()
    {
        return $this->belongsToMany(MunicipalityVaccination::class, 'pv_mv');
    }
}
