<?php

use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('en_GB');

        for ($i=0; $i < 10; $i++) { 
            
            DB::table('categories')->insert([
                'name' => Str::random(10),
                'description' => Str::random(100)
            ]);

        }
    }
}
