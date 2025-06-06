<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class GenreSeeder extends Seeder
{
    public function run()
    {
        $data = [
            'genre_name' => 'Gothic Fiction',
            'created_at' => Time::now(),
            'updated_at' => Time::now()
        ];

        $this->db->table('genres')->insert($data);
    }
}
