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

        // DB::table('contents')->insert([
        //     'id' => id,
        //     'name' => '',
        //     'section' => '',
        // ]);
        // DB::table('content_data')->insert([
        //     'content_id' => id,
        //     'path' => '',
        //     'page_title' => '',
        //     'seo_info' => '',
        //     'og_img' => '',
        //     'cover' => '',
        // ]);

        DB::table('contents')->insert([
            'id' => 1,
            'name' => 'Home',
        ]);
        DB::table('content_data')->insert([
            'content_id' => 1,
            'path' => '',
            'page_title' => 'Julio Bergman',
            'seo_info' => null,
            'og_img' => null,
            'cover' => null,
        ]);
        DB::table('contents')->insert([
            'id' => 2,
            'name' => 'Logofolio',
        ]);
        DB::table('content_data')->insert([
            'content_id' => 2,
            'path' => 'media/logos',
            'page_title' => 'Logofoloio | Julio Bergman',
            'seo_info' => 'Logo | Branding | Logotipo',
            'og_img' => null,
            'cover' => null,
        ]);




        $update = [
            'created_at' => now(),
            'updated_at' => now()
        ];
        DB::table('contents')->update($update);
        DB::table('content_data')->update($update);
    }
}
