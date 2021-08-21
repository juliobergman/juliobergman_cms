<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ContentDataSeeder extends Seeder
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
                'content_id' => 1,
                'path' => '/',
                'page_title' => '',
                'seo_info' => 'Freelancer, Graphic & Web Design',
                'og_img' => null,
                'cover' => null,
            ],
            [
                'id' => 2,
                'content_id' => 2,
                'path' => '/media',
                'page_title' => 'Media | Branding | 3D Rendering | Photography | Development',
                'seo_info' => 'Media Archive',
                'og_img' => null,
                'cover' => null,
            ],
            [
                'id' => 3,
                'content_id' => 3,
                'path' => '/dev',
                'page_title' => 'Development',
                'seo_info' => 'Development',
                'og_img' => null,
                'cover' => null,
            ],
            [
                'id' => 4,
                'content_id' => 4,
                'path' => '/lab',
                'page_title' => 'Lab',
                'seo_info' => 'Testing & Side Projects',
                'og_img' => null,
                'cover' => null,
            ],
            [
                'id' => 5,
                'content_id' => 5,
                'path' => '/about',
                'page_title' => 'About Me',
                'seo_info' => 'About Me',
                'og_img' => null,
                'cover' => null,
            ],
            [
                'id' => 6,
                'content_id' => 6,
                'path' => '/contact',
                'page_title' => 'Contact',
                'seo_info' => 'Keep in touch',
                'og_img' => null,
                'cover' => null,
            ],
            [
                'id' => 7,
                'content_id' => 7,
                'path' => '/media/covers',
                'page_title' => 'Covers',
                'seo_info' => 'Covers',
                'og_img' => null,
                'cover' => null,
            ],
            [
                'id' => 8,
                'content_id' => 8,
                'path' => '/media/graphic',
                'page_title' => 'Graphic Design',
                'seo_info' => 'Flyers, Branding & Graphic Design',
                'og_img' => null,
                'cover' => null,
            ],
            [
                'id' => 9,
                'content_id' => 9,
                'path' => '/media/logo',
                'page_title' => 'Logofolio',
                'seo_info' => 'Logofolio',
                'og_img' => null,
                'cover' => null,
            ],
            [
                'id' => 10,
                'content_id' => 10,
                'path' => '/media/photo',
                'page_title' => 'Photography',
                'seo_info' => 'Photography',
                'og_img' => null,
                'cover' => null,
            ],
            [
                'id' => 11,
                'content_id' => 11,
                'path' => '/media/recent',
                'page_title' => 'Recent',
                'seo_info' => 'Recent',
                'og_img' => null,
                'cover' => null,
            ],
            [
                'id' => 12,
                'content_id' => 12,
                'path' => '/media/render',
                'page_title' => 'Renders',
                'seo_info' => 'Renders',
                'og_img' => null,
                'cover' => null,
            ],
            [
                'id' => 13,
                'content_id' => 13,
                'path' => '/media/resources',
                'page_title' => 'Resources',
                'seo_info' => 'Resources',
                'og_img' => null,
                'cover' => null,
            ],
            [
                'id' => 14,
                'content_id' => 14,
                'path' => '/media/trash',
                'page_title' => 'Trash',
                'seo_info' => 'Trash',
                'og_img' => null,
                'cover' => null,
            ],
            [
                'id' => 15,
                'content_id' => 15,
                'path' => '/project/cervezabenitz',
                'page_title' => 'Cervecería Benitz | Brewery',
                'seo_info' => 'Cervecería Benitz | Brewery',
                'og_img' => null,
                'cover' => null,
            ],
            [
                'id' => 16,
                'content_id' => 16,
                'path' => '/project/chidos',
                'page_title' => "Chido's | Branding",
                'seo_info' => "Chido's | Branding",
                'og_img' => null,
                'cover' => null,
            ],
            [
                'id' => 17,
                'content_id' => 17,
                'path' => '/project/kevingerig',
                'page_title' => 'DJ Kevin Gerig | Branding',
                'seo_info' => 'DJ Kevin Gerig | Branding',
                'og_img' => null,
                'cover' => null,
            ],
            [
                'id' => 18,
                'content_id' => 18,
                'path' => '/project/landmann',
                'page_title' => 'Landmann Brauhaus | Brewery',
                'seo_info' => 'Landmann Brauhaus | Brewery',
                'og_img' => null,
                'cover' => null,
            ],
            [
                'id' => 19,
                'content_id' => 19,
                'path' => '/project/moebel',
                'page_title' => 'Moebel Furniture',
                'seo_info' => 'Moebel Furniture',
                'og_img' => null,
                'cover' => null,
            ],
        ];

        DB::table('content_data')->insert($data);
        $update = [
            'created_at' => now(),
            'updated_at' => now()
        ];
        DB::table('content_data')->update($update);
    }
}
