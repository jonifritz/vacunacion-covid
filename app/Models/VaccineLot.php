<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VaccineLot extends Model
{
    use HasFactory;

    protected $fillable = [
        'vaccine_id',
        'description',
        'admission_date',
        'quantity'
    ];

    public function vaccine_name()
    {
        return $this->belongsTo(TypeVaccine::class, 'vaccine_id');
    }

    public function regions()
    {
        return $this->belongsToMany(ProvinceVaccination::class, 'vl_pv');
    }
}
