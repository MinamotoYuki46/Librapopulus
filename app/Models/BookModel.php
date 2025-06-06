<?php

namespace App\Models;

use CodeIgniter\Model;

class BookModel extends Model
{
    protected $table = 'book';
    protected $allowedFields = [
        'title',
        'author',
        'slug',
        'book_cover',
        'published_date',
        'total_pages',
        'description',
        'created_at',
        'updated_at'
    ];

    protected $useTimestamps = true;

}