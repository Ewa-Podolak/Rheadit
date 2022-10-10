<?php

namespace Database\Seeders;

use App\Models\post;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class postsSeeder extends Seeder
{
    public function run()
    {
        post::insert(['userid' => 2, 'head' => 'GeneralPost', 'body' => 'This is the first post', 'community' => 'homepage']);
        post::insert(['userid' => 1, 'head' => 'firstpost', 'body' => 'This would be the body', 'community' => 'Backend']);
        post::insert(['userid' => 2, 'head' => 'secondpost', 'body' => 'This would be the body', 'community' => 'Frontend']);

        post::factory()->count(7)->create();
    }
}
