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
            ],
            [
            'id' => 2,
            'folio' => 'media',
            'name' => 'Media',
            'subtitle' => null,
            'path' => '/media',
            ],
            [
            'id' => 3,
            'folio' => 'dev',
            'name' => 'Development',
            'subtitle' => null,
            'path' => '/dev',
            ],
            [
            'id' => 4,
            'folio' => 'lab',
            'name' => 'Laboratory',
            'subtitle' => null,
            'path' => '/lab',
            ],
            [
            'id' => 5,
            'folio' => 'about',
            'name' => 'About',
            'subtitle' => null,
            'path' => '/about',
            ],
            [
            'id' => 6,
            'folio' => 'contact',
            'name' => 'Contact',
            'subtitle' => null,
            'path' => '/contact',
            ],
            [
            'id' => 7,
            'folio' => 'covers',
            'name' => 'Covers',
            'subtitle' => null,
            'path' => '/media/covers',
            ],
            [
            'id' => 8,
            'folio' => 'graphic',
            'name' => 'Graphic Design',
            'subtitle' => null,
            'path' => '/media/graphic',
            ],
            [
            'id' => 9,
            'folio' => 'logofolio',
            'name' => 'Logofolio',
            'subtitle' => null,
            'path' => '/media/logofolio',
            ],
            [
            'id' => 10,
            'folio' => 'photo',
            'name' => 'Photography',
            'subtitle' => null,
            'path' => '/media/photo',
            ],
            [
            'id' => 11,
            'folio' => 'recent',
            'name' => 'Recent',
            'subtitle' => null,
            'path' => '/media/recent',
            ],
            [
            'id' => 12,
            'folio' => 'renders',
            'name' => 'Renders',
            'subtitle' => null,
            'path' => '/media/renders',
            ],
            [
            'id' => 13,
            'folio' => 'resources',
            'name' => 'Resources',
            'subtitle' => null,
            'path' => '/media/resources',
            ],
            [
            'id' => 14,
            'folio' => 'trash',
            'name' => 'Trash',
            'subtitle' => null,
            'path' => '/media/trash',
            ],
            [
            'id' => 15,
            'folio' => 'cervezabenitz',
            'name' => 'Cervecería Benitz',
            'subtitle' => 'Branding | Product Rendering',
            'path' => '/project/cervezabenitz',
            ],
            [
            'id' => 16,
            'folio' => 'chidos',
            'name' => 'Chidos',
            'subtitle' => null,
            'path' => '/project/chidos',
            ],
            [
            'id' => 17,
            'folio' => 'kevingerig',
            'name' => 'Kevin Gerig',
            'subtitle' => null,
            'path' => '/project/kevingerig',
            ],
            [
            'id' => 18,
            'folio' => 'landmann',
            'name' => 'Landmann Brauhaus',
            'subtitle' => null,
            'path' => '/project/landmann',
            ],
            [
            'id' => 19,
            'folio' => 'moebel',
            'name' => 'Moebel Furniture',
            'subtitle' => null,
            'path' => '/project/moebel',
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
