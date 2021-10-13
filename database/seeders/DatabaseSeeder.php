<?php

namespace Database\Seeders;

use App\Models\Content;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UserSeeder::class,
            CountrySeeder::class,
            // MediaCategorySeeder::class,
            // ContentSeeder::class,
            // ContentDataSeeder::class,
            // SectionSeeder::class,
            // ConnectionSeeder::class
        ]);
    }
}
