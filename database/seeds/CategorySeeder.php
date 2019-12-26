<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    public function run(Faker $faker)
    {
        $countUsers = DB::table('users')->count();

        for ($i=0; $i < rand(10, 20); $i++) {
            $title = $faker->dayOfMonth. ' ' .$faker->unique()->country;
            $data = [
                'parent_id' => 0,
                'user_id' => rand(1, $countUsers - 1),
                'title' => $title,
                'slug' => Str::slug($title),
                'description' => $faker->text,
            ];
            DB::table('categories')->insert($data);
        }
    }
}
