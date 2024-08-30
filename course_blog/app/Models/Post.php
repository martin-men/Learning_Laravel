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
    public function category(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        // hasOne, hasMany, belongsTo, belongsToMany
        return $this->belongsTo(Category::class);
    }

    public function author(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function comments(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Comment::class);
    }

    /* QUERY SCOPES */
    // Query is automatically passed by Laravel
    public function scopeFilter($query, array $filters): void // Post::filter()
    {
        $query->when(
            $filters['search'] ?? false,
            fn($query, $search) => // Here I continue creating the sql query if the user is searching for something (to filter)
                $query->where(
                    fn($query) =>
                        $query->where('title', 'like', '%' . $search . '%')
                              ->orWhere('body', 'like', '%' . $search . '%')
            )
        );
        /*        $query->when($filters['category'] ?? false, fn($query, $category) => $query
            ->whereExists(fn($query) => $query->from('categories')
                ->whereColumn('categories.id', 'posts.category_id') // When we want to evaluate a column and not a specific value
                ->where('categories.slug', $category)
            )
        );*/

        $query->when(
            $filters['category'] ?? false,
            fn($query, $category) =>
            $query->whereHas('category', fn($query) =>
            $query->where('slug', $category))
        );

        $query->when(
            $filters['author'] ?? false,
            fn($query, $author) =>
            $query->whereHas('author', fn($query) =>
            $query->where('username', $author))
        );
    }
}
