<?php

namespace App\Models;

use CodeIgniter\Model;

class ProfileModel extends Model
{
    protected $table = 'profile';
    protected $primaryKey = 'user_id';
    protected $useAutoIncrement = false; 
    protected $allowedFields = [
        'user_id',
        'full_name',
        'city',
        'country',
        'description',
        'favorite_genres',
        'picture',
        'created_at',
        'updated_at'
    ];

    protected $useTimestamps = true;
}