<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Comment;
use App\Models\User;
use App\Models\Post;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        /* WITH FACTORIES */
        /*      Random data except for what is specified, if nothing is specified, everything is random */
        $firstUser = User::factory()->create([
            'name' => 'John Doe'
        ]);

        $secondUser = User::factory()->create([
            'name' => 'Malena Bustillos'
        ]);

        Post::factory(5)->create([
            'user_id' => $firstUser->id
        ]);

        Post::factory(3)->create([
            'user_id' => $secondUser->id
        ]);

        Comment::factory(10)->create([
            'user_id' => $firstUser->id
        ]);

        Comment::factory(10)->create([
            'user_id' => $secondUser->id
        ]);

        // $user = User::factory()->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // /* CATEGORIES */
        // $personal = Category::create([
        //     'name' => 'Personal',
        //     'slug' => 'personal',
        // ]);
        // $work = Category::create([
        //     'name' => 'Work',
        //     'slug' => 'work',
        // ]);
        // $family = Category::create([
        //     'name' => 'Family',
        //     'slug' => 'family',
        // ]);

        // /* POSTS */
        // Post::create([
        //     'user_id' => $user->id,
        //     'category_id' => $family->id,
        //     'slug' => 'my-family-post',
        //     'title' => 'My Family Post',
        //     'excerpt' => 'This is the excerpt of my family post',
        //     'body' => 'This is the body of my family post'
        // ]);
        // Post::create([
        //     'user_id' => $user->id,
        //     'category_id' => $work->id,
        //     'slug' => 'my-work-post',
        //     'title' => 'My Work Post',
        //     'excerpt' => 'This is the excerpt of my work post',
        //     'body' => 'This is the body of my work post'
        // ]);

    }
}
