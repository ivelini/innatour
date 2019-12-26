<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $arrRoles = [
            ['name' => 'admin'],
            ['name' => 'manager'],
            ['name' => 'distributor'],
            ['name' => 'user']
        ];

        if (DB::table('roles')->count() < 1 || DB::table('roles')->count() == null) {
            DB::table('roles')->insert($arrRoles);
        }
    }
}
