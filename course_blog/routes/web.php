<?php

use Illuminate\Support\Facades\Route;
use App\Models\Post;
use App\Models\Category;
use App\Models\User;
use App\Http\Controllers\PostController;

Route::get('/', [PostController::class, 'index'])->name('home');

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
Route::get('posts/{post:slug}', [PostController::class, 'show']);

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
