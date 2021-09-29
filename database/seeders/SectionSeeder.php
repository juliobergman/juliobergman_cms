<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sections = [
            ['name' => 'Home'],
            ['name' => 'Lab'],
            ['name' => 'Media'],
        ];

        DB::table('sections')->insert($sections);

        $update = [
            'created_at' => now(),
            'updated_at' => now()
        ];

        DB::table('sections')->update($update);
    }
}
