<?php

namespace App\Models;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\File;
use Spatie\YamlFrontMatter\YamlFrontMatter;

class Post
{

    public $title;
    public $excerpt;
    public $date;
    public $body;
    public $slug;

    public function __construct($title, $excerpt, $date, $body, $slug)
    {
        $this->title = $title;
        $this->excerpt = $excerpt;
        $this->date = $date;
        $this->body = $body;
        $this->slug = $slug;
    }

    public static function find($slug)
    {

        return static::all()->firstWhere('slug', $slug);

        // INITIAL APPROACH

        // $path = "../resources/posts/{$slug}.html";

        // if (!file_exists($path)) {
        //     // dd('File does not exist!'); // dd() es un helper de Laravel que detiene la ejecución del código y muestra el contenido de la variable
        //     // abort(404); // abort() es un helper de Laravel que detiene la ejecución del código y muestra un error 404 (en este caso)
        //     throw new ModelNotFoundException(); // ModelNotFoundException() es una excepción de Laravel que se lanza cuando no se encuentra un modelo
        // }

        // return cache()->remember(
        //     "post.{$slug}",
        //     now()->addMinutes(20),
        //     fn() => file_get_contents($path) // cache() es un helper de Laravel que permite almacenar en caché el contenido de un archivo por cierto tiempo
        // );

    }

    public static function all()
    {

        return cache()->rememberForever('posts.all', function () {
            return collect(File::files(resource_path('posts')))->map(function ($file) {
                $document = YamlFrontMatter::parse(file_get_contents($file));
                return new Post(
                    $document->title,
                    $document->excerpt,
                    $document->date,
                    $document->body(),
                    $document->slug
                );
            })->sortByDesc('date');
        });

    }
}
