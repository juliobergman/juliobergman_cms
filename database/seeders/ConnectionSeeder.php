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
                'content_id' => '9',
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
        ];


        DB::table('connections')->insert($data);
        $update = [
            'created_at' => now(),
            'updated_at' => now()
        ];
        DB::table('connections')->update($update);
    }
}
