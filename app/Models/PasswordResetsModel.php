<?php

namespace App\Models;

use CodeIgniter\Model;

class PasswordResetsModel extends Model
{
    protected $table = 'password_resets';
    protected $primaryKey = 'id';

    protected $allowedFields = ['email', 'token', 'created_at'];

    protected $useTimestamps = false; 
    protected $returnType    = 'array';
}
