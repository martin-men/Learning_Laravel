<?php

use Illuminate\Support\Facades\Route;
use App\Models\Post;
use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Facades\File;

Route::get('/', function () {

    $posts = Post::latest()->with('category', 'author')->get();
                                            // Find all posts but also all categories related te the found posts (this solves the N+1 problem)
                                            // The N+1 problem is when you have a query that fetches a collection of models and then for each model you fetch a related model
                                            // This happens because Laravel uses lazy loading by default, which means that it only fetches the related model when you access it
                                            // The solution is to use eager loading, which fetches all the related models at once
    
    /* Opuesto de with() */
    // $posts = Post::without('category', 'author')->get(); // Find all posts but without the user and category related

    //$posts = Post::all(); // Find all posts and pass them to the view called "posts"
    return view('posts', [
        'posts' => $posts,
        'categories' => Category::all()
    ]);

})->name('home');

// Route::get('post/{post}', function ($slug) { // En Laravel, al colocar {algo entre llaves} se está indicando que se espera un parámetro (wildcard)
    
//     // Find a post by its slug and pass it to the view called "post"
//     return view('post', ['post' => Post::findOrFail($slug)]); 
        
// }) -> where('post', '[A-z_\-]+'); // where() es un método de Laravel que permite definir una expresión regular para el parámetro (wildcard)
//                                // lanza un error 404 si el parámetro no cumple con la expresión regular

/* Encontrar post por su ID */
// Route::get('post/{post}', function ($id) {

//     return view('post', ['post' => Post::findOrFail($id)]); 
        
// }) -> whereNumber('post');


/* Mapear un ID de un post en la URL directamente con un objeto Post */
// Route::get('post/{post}', function (Post $post) { // Laravel automáticamente busca un post con el ID que se pasa en la URL y lo asigna a la variable $post
    
//     return view('post', ['post' => $post]); 
        
// });


/* Mapear un valor de un atributo único cualquiera de un post a un objeto POST */
Route::get('posts/{post:slug}', function (Post $post) {
    
    return view('post', ['post' => $post]); 
        
});

Route::get('categories/{category:slug}', function (Category $category) {

    return view('posts', [
        'posts' => $category->posts->load(['category', 'author']),
        'categories' => Category::all(),
        'currentCategory' => $category
    ]);

})->name('category');

Route::get('authors/{author:username}', function (User $author) {

    return view('posts', [
        'posts' => $author->posts->load(['category', 'author']),
        'categories' => Category::all()
    ]);

});
