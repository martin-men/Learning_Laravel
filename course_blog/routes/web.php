<?php

use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\PostCommentsController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SessionsController;
use App\services\MailchimpNewsletter;
use Illuminate\Support\Facades\Route;
use App\Models\Post;
use App\Models\Category;
use App\Models\User;
use App\Http\Controllers\PostController;
use App\Http\Middleware\MustBeAdministrator;
use App\Http\Controllers\AdminPostController;

// Single action controller
Route::post('newsletter', NewsletterController::class);

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

Route::post('posts/{post:slug}/comments', [PostCommentsController::class, 'store']);

/* NO LONGER NECESSARY, WE ARE PASSING A CATEGORY AS AN ATTRIBUTE IN THE LINK TO HOME */
/*Route::get('categories/{category:slug}', function (Category $category) {

    return view('posts', [
        'posts' => $category->posts->load(['category', 'author']),
        'categories' => Category::all(),
        'currentCategory' => $category
    ]);

})->name('category');*/

/* NO LONGER NECESSARY, WE ARE PASSING AN AUTHOR AS AN ATTRIBUTE IN THE LINK TO HOME */
// Route::get('authors/{author:username}', function (User $author) {

//     return view('posts.index', [
//         'posts' => $author->posts->load(['category', 'author'])
//     ]);

// });

Route::get("/register", [RegisterController::class, 'create'])->middleware('guest');

Route::post("/register", [RegisterController::class, 'store'])->middleware('guest');

Route::post("/logout", [SessionsController::class, 'destroy'])->middleware('auth');

Route::get("/login", [SessionsController::class, 'create'])->middleware('guest');

Route::post("/login", [SessionsController::class, 'store'])->middleware('guest');

Route::get('admin/posts/create', [AdminPostController::class, 'create'])->middleware(MustBeAdministrator::class);

Route::post('admin/posts', [AdminPostController::class, 'store'])->middleware(MustBeAdministrator::class);

Route::get('admin/posts', [AdminPostController::class, 'index'])->middleware('can:admin');

/* Es posible agrupar rutas que usen un mismo middleware */
Route::middleware(MustBeAdministrator::class)->group(function() {
    Route::get('admin/posts/{post}/edit', [AdminPostController::class, 'edit']);
    Route::patch('admin/posts/{post}', [AdminPostController::class, 'update']);
});

/* It is possible to use a GATE definition at the AppServiceProvider as a middleware like this */
Route::delete('admin/posts/{post}', [AdminPostController::class, 'destroy'])->middleware('can:admin');
