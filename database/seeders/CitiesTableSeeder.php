<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CitiesTableSeeder extends Seeder
{
    public function run(): void
    {
        $cities = [
            ['name' => 'Cairo',        'slug' => 'cairo'],
            ['name' => 'Giza',         'slug' => 'giza'],
            ['name' => 'Alexandria',   'slug' => 'alexandria'],
            ['name' => 'Suez',         'slug' => 'suez'],
            ['name' => 'Port Said',    'slug' => 'port-said'],
            ['name' => 'Ismailia',     'slug' => 'ismailia'],
            ['name' => 'Aswan',        'slug' => 'aswan'],
            ['name' => 'Luxor',        'slug' => 'luxor'],
            ['name' => 'Tanta',        'slug' => 'tanta'],
            ['name' => 'Mansoura',     'slug' => 'mansoura'],
            ['name' => 'Damietta',     'slug' => 'damietta'],
            ['name' => 'Asyut',        'slug' => 'asyut'],
            ['name' => 'Faiyum',       'slug' => 'faiyum'],
            ['name' => 'Minya',        'slug' => 'minya'],
            ['name' => 'Beni Suef',    'slug' => 'beni-suef'],
            ['name' => 'Sohag',        'slug' => 'sohag'],
            ['name' => 'Qena',         'slug' => 'qena'],
            ['name' => 'Kafr El-Sheikh', 'slug' => 'kafr-el-sheikh'],
            ['name' => 'Marsa Matrouh', 'slug' => 'marsa-matrouh'],
            ['name' => 'Hurghada',     'slug' => 'hurghada'],
            ['name' => 'Sharm El-Sheikh', 'slug' => 'sharm-el-sheikh'],
        ];

        DB::table('cities')->insert($cities);
    }
}
