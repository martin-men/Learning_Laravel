<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Category;

class PostController extends Controller
{
    public function index(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
    {
        // Find all posts but also all categories related te the found posts (this solves the N+1 problem)
        // The N+1 problem is when you have a query that fetches a collection of models and then for each model you fetch a related model
        // This happens because Laravel uses lazy loading by default, which means that it only fetches the related model when you access it
        // The solution is to use eager loading, which fetches all the related models at once
        // Here I am creating an sql query
        $posts = Post::latest()->with('category', 'author');

        /* Opuesto de with() */
        // $posts = Post::without('category', 'author')->get(); // Find all posts but without the user and category related

        //$posts = Post::all(); // Find all posts and pass them to the view called "posts"

        // Here I execute the sql query with ->get() and pass the result to the view called "posts"
        // For search, I also execute the query scope ->filter() defined in the Post eloquent model
        return view('posts.index', [
            // 'posts' => $posts->filter(request(['search', 'category', 'author']))->get()

            /* THIS IS FOR AUTOMATIC PAGINATION */
            'posts' => $posts->filter(request(['search', 'category', 'author']))
                ->paginate(6)
                ->withQueryString()

        ]);
    }

    public function show(Post $post): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
    {
        return view('posts.show', ['post' => $post]);
    }

    public function create()
    {
        return view('posts.create');
    }
}
