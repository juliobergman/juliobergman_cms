<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MediaCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
            'id' => 1,
            'name' => 'Recent Uploads',
            ],
            [
            'id' => 2,
            'name' => 'Resources',
            ],
            [
            'id' => 3,
            'name' => 'Covers',
            ],
            [
            'id' => 4,
            'name' => 'Logofolio',
            ],
            [
            'id' => 5,
            'name' => 'Graphic Design',
            ],
            [
            'id' => 6,
            'name' => 'Photography',
            ],
            [
            'id' => 7,
            'name' => 'Product Rendering',
            ],
            [
            'id' => 8,
            'name' => 'Architectural Rendering',
            ]
        ];

        DB::table('media_categories')->insert($data);
        $update = [
            'created_at' => now(),
            'updated_at' => now()
        ];
        DB::table('media_categories')->update($update);
    }
}
