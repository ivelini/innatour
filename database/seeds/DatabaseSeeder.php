<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RolesSeeder::class);
        factory(App\Models\User::class, 1)->create();
        $this->call(RoleUserSeeder::class);
        $this->call(ScopeSeeder::class);
//        $this->call(CategorySeeder::class);
//        $this->call(TourSeeder::class);
    }
}
