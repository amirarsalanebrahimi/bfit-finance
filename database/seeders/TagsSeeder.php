<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TagsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tags = [
            [
                'name' => 'کلینیک',
                'color' => '#193752'
            ],
            [
                'name' => 'باشگاه اکباتان',
                'color' => '#fcca0c'
            ],
            [
                'name' => 'باشگاه تماس',
                'color' => '#0091ff',
            ]
        ];

        foreach ($tags as $tag) {
            Tag::create($tag);
        }
    }
}
