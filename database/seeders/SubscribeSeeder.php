<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SubscribeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    DB::table('subscribes')->insert([
        [
            'offer_id' => 1,
            'webmaster_id' => 3
        ],
        [
            'offer_id' => 2,
            'webmaster_id' => 3
        ],
        [
            'offer_id' => 3,
            'webmaster_id' => 3
        ]
    ]);
}
