<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'birth_year',
        'death_year',
    ];
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'birth_year' => 'integer',
        'death_year' => 'integer'
    ];


    public function books(): HasMany
    {
        return $this->hasMany(Book::class);
    }

    public function mainGenres()
    {
        return Genre::selectRaw('sum(books.sold) as count, genres.*')
            ->join('books', 'books.genre_id', '=', 'genres.id')
            ->whereRaw('books.author_id = ?', $this->id)
            ->groupBy('books.genre_id')
            ->orderByRaw('sum(books.sold) DESC')
            ->get();
    }
    public function mainPublishers()
    {
        return Publisher::selectRaw('sum(books.sold) as count, publishers.*')
            ->join('books', 'books.publisher_id', '=', 'publishers.id')
            ->whereRaw('books.author_id = ?', $this->id)
            ->groupBy('books.publisher_id')
            ->orderByRaw('sum(books.sold) DESC')
            ->get();
    }
}
