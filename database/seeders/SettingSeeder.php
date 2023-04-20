<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $setting =  [
            [
                'less_product' => 3,
                'product_paginate_count' => 100,
                'navbar_color'=>'white',
                'menu_color' => 'white',
                'delete_password' => 'muzik',
                ]
        ];
        DB::table('settings')->insert($setting);
    }
}
