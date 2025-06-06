<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class BookCollectionSeeder extends Seeder
{
    public function run()
    {
        $data = [
            'user_id' => 1,
            'book_id'    => 1,
            'read_page' => 10,
            'rating' => 5,
            'review' =>'A haunting and powerful story with unforgettable characters. A must-read for fans of classic literature.',
            'created_at' => Time::now(),
            'updated_at' => Time::now()
        ];

        $this->db->table('book_collection')->insert($data);
    }
}
