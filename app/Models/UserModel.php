<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'user';
    protected $allowedFields = [
        'username',
        'display_name',
        'email',
        'password',
        'city',
        'country',
        'picture',
        'created_at',
        'updated_at'
    ];

    protected $useTimestamps = true;
}