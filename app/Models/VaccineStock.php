<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VaccineStock extends Model
{
    use HasFactory;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'description',
        'admission_date',
        'quantity',
        'balance',
        'type_vaccine_id',  
    ];

    public function type_vaccine(){
        return $this->belongsTo(TypeVaccine::class);
    }
}
