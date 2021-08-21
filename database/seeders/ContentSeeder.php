<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ContentSeeder extends Seeder
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
            'name' => 'Home',
            ],
            [
            'id' => 2,
            'name' => 'Media',
            ],
            [
            'id' => 3,
            'name' => 'Development',
            ],
            [
            'id' => 4,
            'name' => 'Laboratory',
            ],
            [
            'id' => 5,
            'name' => 'About',
            ],
            [
            'id' => 6,
            'name' => 'Contact',
            ],
            [
            'id' => 7,
            'name' => 'Covers',
            ],
            [
            'id' => 8,
            'name' => 'Graphic Design',
            ],
            [
            'id' => 9,
            'name' => 'Logos',
            ],
            [
            'id' => 10,
            'name' => 'Photography',
            ],
            [
            'id' => 11,
            'name' => 'Recent',
            ],
            [
            'id' => 12,
            'name' => 'Renders',
            ],
            [
            'id' => 13,
            'name' => 'Resources',
            ],
            [
            'id' => 14,
            'name' => 'Trash',
            ],
            [
            'id' => 15,
            'name' => 'Cervecería Benitz',
            ],
            [
            'id' => 16,
            'name' => 'Chidos',
            ],
            [
            'id' => 17,
            'name' => 'Kevin Gerig',
            ],
            [
            'id' => 18,
            'name' => 'Landmann Brauhaus',
            ],
            [
            'id' => 19,
            'name' => 'Moebel Furniture',
            ],
        ];

        DB::table('contents')->insert($data);
        $update = [
            'created_at' => now(),
            'updated_at' => now()
        ];
        DB::table('contents')->update($update);
    }
}
