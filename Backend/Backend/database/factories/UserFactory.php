<?php

namespace Database\Factories;

use App\Models\user;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class userFactory extends Factory
{
    protected $model = user::class;

    public function definition()
    {
        return [
            'username' => str_random(5, 12),
            'password' => Hash::make('password'),
            'email' => $this->faker->unique()->safeEmail(),
        ];
    }
}
