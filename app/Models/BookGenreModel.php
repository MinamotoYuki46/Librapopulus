<?php

namespace App\Models;

use CodeIgniter\Model;

class BookGenreModel extends Model
{
    protected $table = 'book_genres';
    protected $allowedFields = [
        'book_id',
        'genre_id',
        'created_at',
        'updated_at'
    ];

    protected $useTimestamps = true;
}