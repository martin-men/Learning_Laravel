<?php

use Illuminate\Support\Facades\Route;
use App\Models\Post;
use Illuminate\Support\Facades\File;

Route::get('/', function () {

    $posts = Post::all(); // Find all posts and pass them to the view called "posts"
    return view('posts', ['posts' => $posts]);

});

Route::get('post/{post}', function ($slug) { // En Laravel, al colocar {algo entre llaves} se está indicando que se espera un parámetro (wildcard)
    
    // Find a post by its slug and pass it to the view called "post"
    return view('post', ['post' => Post::find($slug)]); 
        
}) -> where('post', '[A-z_\-]+'); // where() es un método de Laravel que permite definir una expresión regular para el parámetro (wildcard)
                               // lanza un error 404 si el parámetro no cumple con la expresión regular
