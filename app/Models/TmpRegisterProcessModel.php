<?php

namespace App\Models;

use CodeIgniter\Model;

class TmpRegisterProcessModel extends Model
{
    protected $table = 'tmp_register_process';
    protected $allowedFields = [
        'username',
        'email',
        'password',
        'full_name',
        'city',
        'province',
        'description',
        'favorite_genres',
        'picture',
        'created_at',
        'updated_at'
    ];

    protected $useTimestamps = true;
}