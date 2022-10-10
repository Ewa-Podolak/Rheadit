<?php

namespace Database\Seeders;

use App\Models\interaction;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class interactionsSeeder extends Seeder
{
    public function run()
    {
        interaction::insert(['userid' => 1, 'commentid' => 1, 'liked' => 0]);
        interaction::insert(['userid' => 2, 'commentid' => 2, 'liked' => 1]);
        interaction::insert(['userid' => 3, 'postid' => 1, 'liked' => 0]);
        interaction::insert(['userid' => 3, 'postid' => 2, 'liked' => 1]);
    }
}
