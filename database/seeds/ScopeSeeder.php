<?php

use Illuminate\Database\Seeder;

class ScopeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (DB::table('scopes')->count() < 1 || DB::table('scopes')->count() == null) {
            DB::table('scopes')->insert(['id' => 0, 'title' => 'Не задано', 'slug' => 'ne_zadano']);
        }
    }
}
