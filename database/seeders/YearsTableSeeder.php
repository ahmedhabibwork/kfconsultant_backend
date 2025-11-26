<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Str;

class YearsTableSeeder extends Seeder
{
    public function run(): void
    {
        $years = range(1990, 2030);

        foreach ($years as $year) {
            DB::table('years')->updateOrInsert(
                ['title' => $year,'slug' => Str::slug($year)],
            );
        }
    }
}
