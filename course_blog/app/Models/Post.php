<?php

namespace App\Models;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\File;

class Post {
    public static function find($slug) {
    
        $path = "../resources/posts/{$slug}.html";

        if (!file_exists($path)) {
            // dd('File does not exist!'); // dd() es un helper de Laravel que detiene la ejecución del código y muestra el contenido de la variable
            // abort(404); // abort() es un helper de Laravel que detiene la ejecución del código y muestra un error 404 (en este caso)
            throw new ModelNotFoundException(); // ModelNotFoundException() es una excepción de Laravel que se lanza cuando no se encuentra un modelo
        }
    
        return cache()->remember("post.{$slug}", now() -> addMinutes(20), fn() => // cache() es un helper de Laravel que permite almacenar en caché el contenido de un archivo por cierto tiempo
            file_get_contents($path)
        );
    
    }

    public static function all() {
        
        $files = File::files(resource_path('posts'));
        
        return array_map(function ($file) {
            return $file->getContents();
        }, $files);
    
    }
}

?>
