<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class OfferSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('offers')->insert([
            [
                'name' => 'SkillFactory',
                'subjects' => 'IT-learning',
                'advertiser_id' => 2,
                'url' => 'https://skillfactory.ru',
                'price' => 0.05,
                'active' => 1
            ],
            [
                'name' => 'Bootstrap',
                'subjects' => 'web-developing',
                'advertiser_id' => 2,
                'url' => 'https://getbootstrap.com/',
                'price' => 0.04,
                'active' => 1
            ],
            [
                'name' => 'itlogia',
                'subjects' => 'web-developing',
                'advertiser_id' => 2,
                'url' => 'https://itlogia.ru/',
                'price' => 0.02,
                'active' => 1
            ]
        ]);
    }
}
