<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserData;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory(1)
        ->has(UserData::factory())
        ->state([
            'name' => env('OWNER_NAME'),
            'email' => env('OWNER_EMAIL'),
            'password' => Hash::make(env('OWNER_PASSWORD'))
        ])
        ->create();
    }
}
