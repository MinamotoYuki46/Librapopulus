<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class BookGenreSeeder extends Seeder
{
    public function run()
    {
        $data = [
            'book_id' => 1,
            'genre_id' => 1,
            'created_at' => Time::now(),
            'updated_at' => Time::now()
        ];

        $this->db->table('book_genres')->insert($data);
    }
}
