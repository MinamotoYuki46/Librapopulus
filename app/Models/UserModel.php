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
        'full_name',
        'role',
        'city',
        'province',
        'description',
        'favorite_genres',
        'picture',
        'created_at',
        'updated_at'
    ];

    protected $useTimestamps = true;

    protected $validationRules    = [
        'username' => 'required|string|is_unique[user.username]|min_length[1]|max_length[30]|regex_match[/^(?!.*[.]{2})(?!.*[_.]$)(?!^[_.])[a-zA-Z0-9._]+$/]',
        'email' => 'required|string|is_unique[user.email]',
        'password' => 'required|string'
    ];

    protected $validationMessages = [
        'username' => [
            'required' => 'username wajib diisi!',
            'is_unique' => 'username sudah ada, silahkan masukkan username yang lain',
            'min_length' => 'username minimal 1 karakter',
            'max_length' => 'username maksimal 30 karakter',
            'regex_match' => 'username hanya boleh huruf, angka, titik, dan underscore. Tidak boleh diawali/diakhiri titik/underscore atau dua titik berurutan'
        ],
        'email' => [
            'required' => 'email wajib diisi!',
            'is_unique' => 'email sudah ada, silhakan gunakan email yang lain'
        ],
        'password' => ['required' => 'password wajib diisi!']
    ];


    function getDataUser(int $userId){
        return $this->select('
            username,
            full_name,
            city,
            province,
            description,
            favorite_genres,
            picture
        ')
        ->where('id', $userId)
        ->asArray()
        ->first();
    }

    function getDataUserByUsername(string $username){
        return $this->select('
            id,
            full_name,
            city,
            province,
            description,
            favorite_genres,
            picture
        ')
        ->where('username', $username)
        ->asArray()
        ->first();
    }
}