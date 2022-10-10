<?php

namespace Database\Seeders;

use App\Models\community;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class communitySeeder extends Seeder
{
    public function run()
    {
        community::insert(['userid' => 1, 'community' => 'Backend', 'authority' => 'owner']);
        community::insert(['userid' => 2, 'community' => 'Frontend', 'authority' => 'owner']);
        community::insert(['userid' => 3, 'community' => 'Backend', 'authority' => 'member']);
        community::insert(['userid' => 3, 'community' => 'Frontend', 'authority' => 'mod']);
    }
}
