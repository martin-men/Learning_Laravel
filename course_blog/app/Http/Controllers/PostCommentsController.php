<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class PostCommentsController extends Controller
{
    public function store(Post $post)
    {
        // Validate
        request()->validate([
            'body' => 'required'
        ]);

        // Add a comment to the given post
        // This will automatically associate the post ID to the new comment
        $post->comments()->create([
            'user_id' => auth()->user()->id,
            'body' => request('body')
        ]);

        return back();
    }
}
