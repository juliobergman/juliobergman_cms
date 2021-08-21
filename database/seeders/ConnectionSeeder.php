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
                'section' => 1,
                'content' => '9',
                'public' => 'yes',
                'oby' => 1,
            ],
            [
                'section' => 1,
                'content' => 15,
                'public' => 'yes',
                'oby' => 2,
            ],
            [
                'section' => 1,
                'content' => 16,
                'public' => 'yes',
                'oby' => 3,
            ],
            [
                'section' => 1,
                'content' => 17,
                'public' => 'yes',
                'oby' => 4,
            ],
            [
                'section' => 1,
                'content' => 18,
                'public' => 'yes',
                'oby' => 5,
            ],
            [
                'section' => 1,
                'content' => 19,
                'public' => 'yes',
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
