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
                'page_title' => null,
                'seo_info' => 'Freelancer, Graphic & Web Design',
                'cover' => null,
            ],
            [
                'id' => 2,
                'content_id' => 2,
                'page_title' => 'Media | Branding | 3D Rendering | Photography | Development',
                'seo_info' => 'Media Archive',
                'cover' => null,
            ],
            [
                'id' => 3,
                'content_id' => 3,
                'page_title' => 'Development',
                'seo_info' => 'Development',
                'cover' => null,
            ],
            [
                'id' => 4,
                'content_id' => 4,
                'page_title' => 'Lab',
                'seo_info' => 'Testing & Side Projects',
                'cover' => null,
            ],
            [
                'id' => 5,
                'content_id' => 5,
                'page_title' => 'About Me',
                'seo_info' => 'About Me',
                'cover' => null,
            ],
            [
                'id' => 6,
                'content_id' => 6,
                'page_title' => 'Contact',
                'seo_info' => 'Keep in touch',
                'cover' => null,
            ],
            // Albums
            [
                'id' => 7,
                'content_id' => 7,
                'page_title' => 'Recent Uploads',
                'seo_info' => 'Recent Uploads',
                'cover' => null,
            ],
            [
                'id' => 8,
                'content_id' => 8,
                'page_title' => 'Resources',
                'seo_info' => 'Resources',
                'cover' => null,
            ],
            [
                'id' => 9,
                'content_id' => 9,
                'page_title' => 'Covers',
                'seo_info' => 'Covers',
                'cover' => null,
            ],
            [
                'id' => 10,
                'content_id' => 10,
                'page_title' => 'Logofolio',
                'seo_info' => 'Logofolio',
                'cover' => null,
            ],
            [
                'id' => 11,
                'content_id' => 11,
                'page_title' => 'Graphic Design',
                'seo_info' => 'Flyers, Branding & Graphic Design',
                'cover' => null,
            ],
            [
                'id' => 12,
                'content_id' => 12,
                'page_title' => 'Photography',
                'seo_info' => 'Photography',
                'cover' => null,
            ],
            [
                'id' => 13,
                'content_id' => 13,
                'page_title' => 'Product Rendering',
                'seo_info' => 'Product Rendering',
                'cover' => null,
            ],
            [
                'id' => 14,
                'content_id' => 14,
                'page_title' => 'Architectural Rendering',
                'seo_info' => 'Architectural Rendering',
                'cover' => null,
            ],
            // Projects
            [
                'id' => 15,
                'content_id' => 15,
                'page_title' => 'Cervecería Benitz | Brewery',
                'seo_info' => 'Cervecería Benitz | Brewery',
                'cover' => null,
            ],
            [
                'id' => 16,
                'content_id' => 16,
                'page_title' => "Chido's | Branding",
                'seo_info' => "Chido's | Branding",
                'cover' => null,
            ],
            [
                'id' => 17,
                'content_id' => 17,
                'page_title' => 'DJ Kevin Gerig | Branding',
                'seo_info' => 'DJ Kevin Gerig | Branding',
                'cover' => null,
            ],
            [
                'id' => 18,
                'content_id' => 18,
                'page_title' => 'Landmann Brauhaus | Brewery',
                'seo_info' => 'Landmann Brauhaus | Brewery',
                'cover' => null,
            ],
            [
                'id' => 19,
                'content_id' => 19,
                'page_title' => 'Moebel Furniture',
                'seo_info' => 'Moebel Furniture',
                'cover' => null,
            ],
            [
                'id' => 20,
                'content_id' => 20,
                'page_title' => 'Bettys Haus',
                'seo_info' => 'Bettys Haus',
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
