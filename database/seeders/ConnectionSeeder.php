<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ConnectionSeeder extends Seeder
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
                'section_id' => 1,
                'content_id' => '10',
                'public' => 'no',
                'oby' => 1,
            ],
            [
                'section_id' => 1,
                'content_id' => 15,
                'public' => 'no',
                'oby' => 2,
            ],
            [
                'section_id' => 1,
                'content_id' => 16,
                'public' => 'no',
                'oby' => 3,
            ],
            [
                'section_id' => 1,
                'content_id' => 17,
                'public' => 'no',
                'oby' => 4,
            ],
            [
                'section_id' => 1,
                'content_id' => 18,
                'public' => 'no',
                'oby' => 5,
            ],
            [
                'section_id' => 1,
                'content_id' => 19,
                'public' => 'no',
                'oby' => 6,
            ],
            // Media
            [
                'section_id' => 3,
                'content_id' => 10,
                'public' => 'no',
                'oby' => 1,
            ],
            [
                'section_id' => 3,
                'content_id' => 11,
                'public' => 'no',
                'oby' => 2,
            ],
            [
                'section_id' => 3,
                'content_id' => 12,
                'public' => 'no',
                'oby' => 3,
            ],
            [
                'section_id' => 3,
                'content_id' => 13,
                'public' => 'no',
                'oby' => 4,
            ],
            [
                'section_id' => 3,
                'content_id' => 14,
                'public' => 'no',
                'oby' => 5,
            ],
            [
                'section_id' => 1,
                'content_id' => 20,
                'public' => 'no',
                'oby' => 7,
            ],
        ];


        DB::table('connections')->insert($data);
        $update = [
            'created_at' => now(),
            'updated_at' => now()
        ];
        DB::table('connections')->update($update);
    }
}
