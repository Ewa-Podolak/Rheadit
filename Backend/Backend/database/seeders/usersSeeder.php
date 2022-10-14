<?php

namespace Database\Seeders;

use App\Models\user;
use Illuminate\Database\Seeder;

class usersSeeder extends Seeder
{
    public function run()
    {
        user::insert(['username' => 'Ewa', 'password' => 'Potato', 'email' => 'ewa@random.com']);
        user::insert(['username' => 'Millie', 'password' => 'Pineapple', 'email' => 'millie@random.com']);
        user::insert(['username' => 'Will', 'password' => 'Surething', 'email' => 'will@random.com']);
        user::insert(['username' => 'Frontend']);
        user::insert(['username' => 'Backend']);
        user::insert(['username' => 'homepage']);

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
