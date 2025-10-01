<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tag;
use Illuminate\Support\Str;

class TagSeeder extends Seeder
{
    public function run(): void
    {
        $tags = [
            'Cairo Day Tours',
            'Oases Day Tours',
            'Alexandria Day Tours',
            'Aswan Day Tours',
            'Luxor Day Tours',
            'Red Sea Day Tours',
        ];

        foreach ($tags as $tag) {
            Tag::firstOrCreate(
                ['slug' => Str::slug($tag)],
                ['name' => $tag]
            );
        }
    }
}
