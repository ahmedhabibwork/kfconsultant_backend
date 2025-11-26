<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class StatusesTableSeeder extends Seeder
{
    public function run(): void
    {
        $statuses = [
            'On Site',
            'Completed',
            'Under Construction',
        ];

        foreach ($statuses as $name) {
            DB::table('status')->updateOrInsert(
                ['slug' => Str::slug($name)],
                [
                    'title' => $name,
                    'slug' => Str::slug($name),
                ]
            );
        }
    }
}
