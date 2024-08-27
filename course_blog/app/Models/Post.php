<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    
    use HasFactory;

    /* For eager loading by default, use with (this will load the category and author instances for each corresponding post) */
    // protected $with = ['category', 'author'];

    // Se usa para determinar que campos se pueden llenar por medio de ::create([])
    // protected $fillable = ['title', 'excerpt', 'body'];

    // Se usa para determinar que campos no se pueden llenar por medio de ::create([])
    // protected $guarded = ['id'];

    // Se usa para habilitar todos los campos para la inserción masiva
    protected $guarded = [];

    /* Eloquent relationship */
    /*
        A esta función se la utiliza como si fuese un atributo
        Laravel se encarga de buscar la relación, solo es necesario especificar a qué modelo pertenece
        Supongo que el nombre de uno de los atributos del modelo Post debe tener una palabra clave con relación al modelo Category
    */
    public function category()
    {
        // hasOne, hasMany, belongsTo, belongsToMany
        return $this->belongsTo(Category::class);
    }

    public function author() {
        return $this->belongsTo(User::class, 'user_id');
    }

}
