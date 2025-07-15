<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $table = 'books';

    protected $primaryKey = 'id_book';

    protected $fillable = [
        'id_category',
        'name_book',
        'cover_book',
        'author',
        'publisher',
        'publication_date',
        'description',
        'stock',
        'isbn',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'id_category');
    }
}