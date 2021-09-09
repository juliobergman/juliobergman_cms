<?php

namespace Database\Factories;

use App\Models\UserData;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserDataFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = UserData::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'profile_pic' => '/storage/factory/avatar/male/avatar-10.jpg',
            'phone' => $this->faker->phoneNumber(),
            'country' => $this->faker->countryCode(),
            'city' => $this->faker->city(),
            'address' => $this->faker->streetAddress(),
            'gender' => 'male',
            'site' => $this->faker->domainName(),
        ];
    }
}
