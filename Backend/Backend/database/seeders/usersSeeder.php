<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\user;

class usersSeeder extends Seeder
{
    public function run()
    {
        user::insert(['username' => 'Ewa', 'password' => 'Potato', 'email' => 'ewa@random.com']);

        user::insert(['username' => 'Millie', 'password' => 'Pineapple', 'email' => 'millie@random.com']);

        user::factory()->count(7)->create();

        $this->call([
            postsSeeder::class,
            interactionsSeeder::class,
            followersSeeder::class,
            communitySeeder::class,
            commentsSeeder::class,
        ]);
    
    }
}
