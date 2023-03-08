<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'name' => 'admin',
                'email' => 'admin@example.com',
                'access_level' => 2,
                'advertiser' => false,
                'webmaster' => false,
                'admin' => true,
                'password' => Hash::make('admin')
            ],
            [
                'name' => 'advertiser',
                'email' => 'advertiser@example.com',
                'access_level' => 2,
                'advertiser' => true,
                'webmaster' => false,
                'admin' => false,
                'password' => Hash::make('advertiser')
            ],
            [
                'name' => 'webmaster',
                'email' => 'webmaster@example.com',
                'access_level' => 2,
                'advertiser' => false,
                'webmaster' => true,
                'admin' => false,
                'password' => Hash::make('webmaster')
            ]
        ]);
    }
}
