<?php

namespace Database\Seeders;

use App\Models\Blog;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->count(30)->blogger()->create();
//        User::factory()->count(1)->admin()->create();

        Blog::factory()->count(50)->create();
        Comment::factory()->count(100)->create();
        // \App\models\User::factory(10)->create();
    }
}
