<?php

namespace Database\Seeders;

use App\Models\follower;
use Illuminate\Database\Seeder;

class followersSeeder extends Seeder
{
    public function run()
    {
        follower::insert(['user' => 1, 'follower' => 2]);
        follower::insert(['user' => 2, 'follower' => 1]);
        follower::insert(['user' => 1, 'follower' => 3]);
        follower::insert(['user' => 2, 'follower' => 3]);
    }
}
