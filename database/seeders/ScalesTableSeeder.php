<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ScalesTableSeeder extends Seeder
{
    public function run(): void
    {
        $scales = [
            '>100,000',
            '>200,000',
            '>50,000',
            '<50,000',
        ];

        foreach ($scales as $name) {
            DB::table('scales')->updateOrInsert(
                ['slug' => Str::slug($name)],
                [
                    'title' => $name,
                    'slug' => Str::slug($name),
                ]
            );
        }
    }
}
