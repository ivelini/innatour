<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $idUsers = DB::table('users')->pluck('id');
        $idNames = DB::table('roles')->pluck('id');

        foreach ($idUsers as $id) {
            $roleUser[] = [
                'user_id' => $id,
                'role_id' => $idNames[0]
            ];
        }

        DB::table('role_user')->insert($roleUser);
    }
}
