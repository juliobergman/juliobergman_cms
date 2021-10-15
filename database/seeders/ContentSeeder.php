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
            'folio' => 'home',
            'name' => 'Home',
            'subtitle' => null,
            'path' => '/',
            'media_category_id' => null,
            ],
            [
            'id' => 2,
            'folio' => 'media',
            'name' => 'Media',
            'subtitle' => null,
            'path' => '/media',
            'media_category_id' => null,
            ],
            [
            'id' => 3,
            'folio' => 'dev',
            'name' => 'Development',
            'subtitle' => null,
            'path' => '/dev',
            'media_category_id' => null,
            ],
            [
            'id' => 4,
            'folio' => 'lab',
            'name' => 'Laboratory',
            'subtitle' => null,
            'path' => '/lab',
            'media_category_id' => null,
            ],
            [
            'id' => 5,
            'folio' => 'about',
            'name' => 'About',
            'subtitle' => null,
            'path' => '/about',
            'media_category_id' => null,
            ],
            [
            'id' => 6,
            'folio' => 'contact',
            'name' => 'Contact',
            'subtitle' => null,
            'path' => '/contact',
            'media_category_id' => null,
            ],
            // Media Albums
            [
            'id' => 7,
            'folio' => 'recent-uploads',
            'name' => 'Recent Uploads',
            'subtitle' => null,
            'path' => '/media/recent-uploads',
            'media_category_id' => 1,
            ],
            [
            'id' => 8,
            'folio' => 'resources',
            'name' => 'Resources',
            'subtitle' => null,
            'path' => '/media/resources',
            'media_category_id' => 2,
            ],
            [
            'id' => 9,
            'folio' => 'covers',
            'name' => 'Covers',
            'subtitle' => null,
            'path' => '/media/covers',
            'media_category_id' => 3,
            ],
            [
            'id' => 10,
            'folio' => 'logofolio',
            'name' => 'Logofolio',
            'subtitle' => null,
            'path' => '/media/logofolio',
            'media_category_id' => 4,
            ],
            [
            'id' => 11,
            'folio' => 'graphic-design',
            'name' => 'Graphic Design',
            'subtitle' => null,
            'path' => '/media/graphic-design',
            'media_category_id' => 5,
            ],
            [
            'id' => 12,
            'folio' => 'photography',
            'name' => 'Photography',
            'subtitle' => null,
            'path' => '/media/photography',
            'media_category_id' => 6,
            ],
            [
            'id' => 13,
            'folio' => 'product-rendering',
            'name' => 'Product Rendering',
            'subtitle' => null,
            'path' => '/media/product-rendering',
            'media_category_id' => 7,
            ],
            [
            'id' => 14,
            'folio' => 'architectural-rendering',
            'name' => 'Architectural Rendering',
            'subtitle' => null,
            'path' => '/media/architectural-rendering',
            'media_category_id' => 8,
            ],
            // Projects
            [
            'id' => 15,
            'folio' => 'cervezabenitz',
            'name' => 'Cervecería Benitz',
            'subtitle' => 'Branding | Product Rendering',
            'path' => '/project/cervezabenitz',
            'media_category_id' => null,
            ],
            [
            'id' => 16,
            'folio' => 'chidos',
            'name' => 'Chidos',
            'subtitle' => null,
            'path' => '/project/chidos',
            'media_category_id' => null,
            ],
            [
            'id' => 17,
            'folio' => 'kevingerig',
            'name' => 'Kevin Gerig',
            'subtitle' => null,
            'path' => '/project/kevingerig',
            'media_category_id' => null,
            ],
            [
            'id' => 18,
            'folio' => 'landmann',
            'name' => 'Landmann Brauhaus',
            'subtitle' => null,
            'path' => '/project/landmann',
            'media_category_id' => null,
            ],
            [
            'id' => 19,
            'folio' => 'moebel',
            'name' => 'Moebel Furniture',
            'subtitle' => null,
            'path' => '/project/moebel',
            'media_category_id' => null,
            ],
            [
            'id' => 20,
            'folio' => 'bettys-haus',
            'name' => 'Bettys Haus',
            'subtitle' => null,
            'path' => '/project/bettys-haus',
            'media_category_id' => null,
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
