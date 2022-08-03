<?php

use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Faker\Factory as Faker;
use Illuminate\Support\Arr;


class AdvertisementTagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $ads_array = Db::table('advertisements')->select('id')->get()->pluck('id')->toArray();
        $tags_array = Db::table('tags')->select('id')->get()->pluck('id')->toArray();

        $faker = Faker::create('en_GB');

        for ($i = 0; $i < 10; $i++) {

            $random_adv = Arr::random($ads_array);
            $random_tag = Arr::random($tags_array);

            $adv_tag_count = DB::table('advertisements_tags')->where(['advertisement_id' => $random_adv, 'tag_id' => $random_tag])->count();

            if ($adv_tag_count > 0)
                continue;

            DB::table('advertisements_tags')->insert([
                'advertisement_id' => $random_adv,
                'tag_id' => $random_tag,
            ]);
        }
    }
}
