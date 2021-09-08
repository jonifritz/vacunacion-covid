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
}
