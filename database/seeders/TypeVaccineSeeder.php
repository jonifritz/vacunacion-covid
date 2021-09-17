<?php

namespace Database\Seeders;

use App\Models\TypeVaccine;
use Illuminate\Database\Seeder;

class TypeVaccineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $vaccines = [
            [
                'id' => 1,
                'name' => 'Pfizer',
                'doses_number' => 2,
                'country' => 'USA',
                'laboratory' => 'USA Lab',
                'counter' => 0
            ],
            [
                'id' => 2,
                'name' => 'Sputnik',
                'doses_number' => 2,
                'country' => 'Rusia',
                'laboratory' => 'Rusia Lab',
                'counter' => 0
            ],
            [
                'id' => 3,
                'name' => 'Sinopharm',
                'doses_number' => 2,
                'country' => 'China',
                'laboratory' => 'China Lab',
                'counter' => 0
            ],
        ];

        TypeVaccine::insert($vaccines);
    }
}
