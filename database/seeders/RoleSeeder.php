<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [[
            'id' => 1,
            'name' => 'superadmin',
            'code' => 'SUPER_ADMIN',
        ], [
            'id' => 2,
            'name' => 'administrador nacional',
            'code' => 'ADMIN_NAC',
        ], [
            'id' => 3,
            'name' => 'administrador provincial',
            'code' => 'ADMIN_PROV',
        ], [
            'id' => 4,
            'name' => 'admistrador municipal',
            'code' => 'ADMIN_MUNICIPAL',
        ], [
            'id' => 5,
            'name' => 'administrador hospital',
            'code' => 'ADMIN_HOSPITAL',
        ]];

        Role::insert($roles);
    }
}
