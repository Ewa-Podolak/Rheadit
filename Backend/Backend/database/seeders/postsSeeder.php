<?php

namespace Database\Seeders;

use App\Models\post;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class postsSeeder extends Seeder
{
    public function run()
    {
        post::factory()->count(7)->create();
    }
}
