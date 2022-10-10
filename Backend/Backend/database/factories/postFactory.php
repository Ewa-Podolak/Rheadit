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
                'userid' => 2,
                'head' => str_random(5, 30),
                'body' => str_random(5, 150),
                'community' => 'Frontend',
        ];
        }
        else
        {
            return [
                'userid' => 1,
                'head' => str_random(5, 30),  
                'community' => 'Backend',   
        ];
        }
    }
}
