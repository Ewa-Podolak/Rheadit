<?php

namespace Database\Seeders;

use App\Models\comment;
use Illuminate\Database\Seeder;

class commentsSeeder extends Seeder
{
    public function run()
    {
        comment::insert(['postid' => 2, 'userid' => 3, 'comment' => 'Nice Backend stuff']);
        comment::insert(['postid' => 3, 'userid' => 3, 'comment' => 'Nice Frontend stuff']);
    }
}
