<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ScopesTableSeeder extends Seeder
{
    public function run(): void
    {
        $scopes = [
            'Architecture & Landscape Design',
            'Architecture',
            'Architecture & Interior Design',
            'Architecture, Interior & Landscape Design',
            'Architecture, Landscape, Interior & Construction Documents',
            'Full Service Architecture & Engineering Design',
        ];

        foreach ($scopes as $name) {
            DB::table('scopes')->updateOrInsert(
                ['slug' => Str::slug($name)],
                [
                    'title' => $name,
                    'slug' => Str::slug($name),
                ]
            );
        }
    }
}
