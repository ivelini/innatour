<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\DB;

class TourSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $categories = DB::table('categories')->pluck('id');
        $users = DB::table('users')->pluck('id');
        foreach ($categories as $category) {
            for ($i = 0; $i < rand(10, 30); $i++) {
                $data = [
                    'user_id' => $users->random(),
                    'title' => $faker->text(70),
                    'slug' => $faker->slug(6),
                    'description' => $faker->text(3000),
                    'price' => $faker->numberBetween(1000, 90000),
                    'is_published' => (rand(1, 10) > 3)? 1 : 0
                ];
                $tour = new \App\Models\Tour($data);
                $tour->save();
                $tour->categories()->attach($category);
                DB::table('gallery')->insert(['tour_id' => $tour->id, 'path' => 'uploads/img/1.jpg', 'is_header' => 'true']);
            }
        }
    }
}
