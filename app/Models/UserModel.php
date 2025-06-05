<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'user';
    protected $allowedFields = [
        'username',
        'email',
        'password',
        'created_at',
        'updated_at'
    ];

    protected $useTimestamps = true;

    protected $validationRules    = [
        'username' => 'required|string|is_unique[user.username]',
        'email' => 'required|string|is_unique[user.email]',
        'password' => 'required|string'
    ];

    protected $validationMessages = [
        'username' => [
            'required' => 'username wajib diisi!',
            'is_unique' => 'username sudah ada, silahkan masukkan username yang lain'
        ],
        'email' => [
            'required' => 'email wajib diisi!',
            'is_unique' => 'email sudah ada, silhakan gunakan email yang lain'
        ],
        'password' => ['required' => 'password wajib diisi!']
    ];
}