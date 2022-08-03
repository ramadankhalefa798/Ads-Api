<?php

use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Faker\Factory as Faker;
use Illuminate\Support\Arr;

class AdvertisementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $type_array = ['free' , 'paid'];
        // $cats_array = Db::table('categories')->select('id')->get()->pluck('id')->toArray();
        $users_array = Db::table('users')->select('id')->get()->pluck('id')->toArray();

        $faker = Faker::create('en_GB');

        for ($i=0; $i < 10; $i++) { 

            $random_type = Arr::random($type_array);
            // $random_cat = Arr::random($cats_array);
            $random_user = Arr::random($users_array);
            
            DB::table('advertisements')->insert([
                'title' => Str::random(10),
                'description' => Str::random(100),
                'start_date' => $faker->date(),
                'type' => $random_type,
                // 'category_id' => $random_cat,
                'user_id' => $random_user,
            ]);

        }
    }
}
