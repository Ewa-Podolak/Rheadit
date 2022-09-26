<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\post;

class postFactory extends Factory
{
    protected $model = post::class;

    public function definition()
    {
        if(rand(0,1) == 1)
        {
            return [
                'title' => str_random(5, 30),
                'body' => str_random(5, 150),
        ];
        }
        else if(rand(0,1) == 1)
        {
            return [
                'title' => str_random(5, 30),  
        ];
        }
    }
}
