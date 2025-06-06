<?php

namespace App\Models;

use CodeIgniter\Model;

class GenreModel extends Model
{
    protected $table = 'genres';
    protected $allowedFields = [
        'genre_name',
        'created_at',
        'updated_at'
    ];

    protected $useTimestamps = true;
}